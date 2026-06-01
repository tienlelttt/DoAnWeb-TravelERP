export const parseApiDate = (value?: string | Date | null): Date | null => {
  if (!value) return null;
  if (value instanceof Date) return Number.isNaN(value.getTime()) ? null : value;

  const raw = String(value).trim();
  const isoLike = raw.match(/^(\d{4})-(\d{2})-(\d{2})(?:[ T].*)?$/);
  if (isoLike) {
    const [, year, month, day] = isoLike;
    return new Date(Number(year), Number(month) - 1, Number(day));
  }

  const viLike = raw.match(/^(\d{1,2})[/-](\d{1,2})[/-](\d{4})(?:[ T].*)?$/);
  if (viLike) {
    const [, day, month, year] = viLike;
    return new Date(Number(year), Number(month) - 1, Number(day));
  }

  const date = new Date(raw);
  return Number.isNaN(date.getTime()) ? null : date;
};

export const formatDisplayDate = (value?: string | Date | null, fallback = 'Đang cập nhật') => {
  const date = parseApiDate(value);
  if (!date) return fallback;

  const day = date.getDate().toString().padStart(2, '0');
  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const year = date.getFullYear().toString();
  return `${day}/${month}/${year}`;
};
