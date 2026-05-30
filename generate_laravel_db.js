const fs = require('fs');
const path = require('path');

const entityDir = path.join(__dirname, '../be/src/main/java/com/digitaltravel/erp/entity');
const modelDir = path.join(__dirname, 'app/Models');
const migrationDir = path.join(__dirname, 'database/migrations');

if (!fs.existsSync(modelDir)) fs.mkdirSync(modelDir, { recursive: true });
if (!fs.existsSync(migrationDir)) fs.mkdirSync(migrationDir, { recursive: true });

const javaFiles = fs.readdirSync(entityDir).filter(f => f.endsWith('.java'));

let migrationsCode = '';
let upCode = "        Schema::disableForeignKeyConstraints();\n";
let downCode = "        Schema::disableForeignKeyConstraints();\n";

javaFiles.forEach(file => {
    const content = fs.readFileSync(path.join(entityDir, file), 'utf-8');
    if (!content.includes('@Entity')) return;

    const classMatch = content.match(/public class (\w+)/);
    if (!classMatch) return;
    const className = classMatch[1];

    let tableName = className;
    const tableMatch = content.match(/@Table\(name\s*=\s*"([^"]+)"/);
    if (tableMatch) tableName = tableMatch[1];

    upCode += `\n        Schema::create('${tableName}', function (Blueprint $table) {\n`;
    downCode += `        Schema::dropIfExists('${tableName}');\n`;

    let modelRelations = [];
    let primaryKey = 'id';
    let isAutoIncrement = true;
    let keyType = 'int';

    // Regex tìm các field trong Java Entity
    const propertyRegex = /((?:@[A-Za-z0-9_]+\s*(?:\([^)]*\))?\s*)*)\s*(?:private\s+|protected\s+|public\s+)?([A-Za-z0-9_<>]+)\s+(\w+)\s*;/g;
    
    let match;
    while ((match = propertyRegex.exec(content)) !== null) {
        const annotations = match[1];
        const type = match[2];
        const name = match[3];

        if (annotations.includes('@Transient')) continue;

        let colName = name;
        const colMatch = annotations.match(/@Column\s*\([^)]*name\s*=\s*"([^"]+)"/);
        if (colMatch) colName = colMatch[1];

        // Primary Key
        if (annotations.includes('@Id')) {
            primaryKey = colName;
            if (type === 'String') {
                upCode += `            $table->string('${colName}', 50)->primary();\n`;
                isAutoIncrement = false;
                keyType = 'string';
            } else {
                upCode += `            $table->id('${colName}');\n`;
                keyType = 'int';
            }
            continue;
        }

        // ManyToOne / OneToOne
        if (annotations.includes('@ManyToOne') || annotations.includes('@OneToOne')) {
            const joinColMatch = annotations.match(/@JoinColumn\s*\([^)]*name\s*=\s*"([^"]+)"/);
            if (joinColMatch) {
                let fkCol = joinColMatch[1];
                let isNullable = !annotations.includes('nullable = false');
                upCode += `            $table->string('${fkCol}', 50)${isNullable ? '->nullable()' : ''};\n`; 
                modelRelations.push(`    public function ${name}() {\n        return $this->belongsTo(${type}::class, '${fkCol}', '${fkCol}'); \n    }\n`);
            }
            continue;
        }

        // OneToMany
        if (annotations.includes('@OneToMany')) {
            const mappedBy = annotations.match(/mappedBy\s*=\s*"([^"]+)"/);
            if (mappedBy) {
                const innerMatch = type.match(/List<(\w+)>/);
                const innerType = innerMatch ? innerMatch[1] : type;
                modelRelations.push(`    public function ${name}() {\n        return $this->hasMany(${innerType}::class, '${mappedBy[1]}'); \n    }\n`);
            }
            continue;
        }

        // Regular Columns
        if (!annotations.includes('@Column')) continue; 

        let length = 255;
        const lenMatch = annotations.match(/length\s*=\s*(\d+)/);
        if (lenMatch) length = lenMatch[1];

        let nullable = annotations.includes('nullable = false') ? '' : '->nullable()';
        let unique = annotations.includes('unique = true') ? '->unique()' : '';

        if (type === 'String') {
            upCode += `            $table->string('${colName}', ${length})${nullable}${unique};\n`;
        } else if (type === 'Integer') {
            upCode += `            $table->integer('${colName}')${nullable}${unique};\n`;
        } else if (type === 'Long') {
            upCode += `            $table->bigInteger('${colName}')${nullable}${unique};\n`;
        } else if (type === 'BigDecimal') {
            upCode += `            $table->decimal('${colName}', 18, 2)${nullable}${unique};\n`;
        } else if (type === 'LocalDate' || type === 'LocalDateTime' || type === 'Date') {
            upCode += `            $table->dateTime('${colName}')${nullable}${unique};\n`;
        } else if (type === 'Boolean') {
            upCode += `            $table->boolean('${colName}')${nullable}${unique};\n`;
        }
    }

    upCode += `            $table->timestamps();\n`;
    upCode += `        });\n`;

    // Model Generation
    let modelCode = `<?php\n\nnamespace App\\Models;\n\nclass ${className} extends BaseModel\n{\n    protected $table = '${tableName}';\n    protected $primaryKey = '${primaryKey}';\n`;
    if (!isAutoIncrement) {
        modelCode += `    public $incrementing = false;\n    protected $keyType = '${keyType}';\n`;
    }
    modelCode += `    protected $guarded = [];\n\n`;
    modelCode += modelRelations.join('\n');
    modelCode += `}\n`;
    
    fs.writeFileSync(path.join(modelDir, `${className}.php`), modelCode);
});

upCode += "        Schema::enableForeignKeyConstraints();\n";
downCode += "        Schema::enableForeignKeyConstraints();\n";

const migrationTemplate = `<?php\n\nuse Illuminate\\Database\\Migrations\\Migration;\nuse Illuminate\\Database\\Schema\\Blueprint;\nuse Illuminate\\Support\\Facades\\Schema;\n\nreturn new class extends Migration\n{\n    public function up()\n    {\n${upCode}    }\n\n    public function down()\n    {\n${downCode}    }\n};\n`;

fs.writeFileSync(path.join(migrationDir, '2026_01_01_000000_create_all_tables.php'), migrationTemplate);
console.log('Thành công: Đã tạo xong 35 Models và 1 Migration tổng!');
