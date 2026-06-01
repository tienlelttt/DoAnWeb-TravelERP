const parseDate = (dateInput?: string | Date | null): Date | null => {
  if (!dateInput) return null;
  if (dateInput instanceof Date) {
    return Number.isNaN(dateInput.getTime()) ? null : dateInput;
  }

  const value = String(dateInput).trim();
  const isoLike = value.match(/^(\d{4})-(\d{2})-(\d{2})(?:[ T].*)?$/);
  if (isoLike) {
    const [, year, month, day] = isoLike;
    return new Date(Number(year), Number(month) - 1, Number(day));
  }

  const vietnameseLike = value.match(/^(\d{1,2})[/-](\d{1,2})[/-](\d{4})(?:[ T].*)?$/);
  if (vietnameseLike) {
    const [, day, month, year] = vietnameseLike;
    return new Date(Number(year), Number(month) - 1, Number(day));
  }

  const date = new Date(value);
  return Number.isNaN(date.getTime()) ? null : date;
};

export const formatDate = (dateString?: string | Date | null): string => {
  const date = parseDate(dateString);
  if (!date) return '-';

  const day = date.getDate().toString().padStart(2, '0');
  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const year = date.getFullYear().toString();

  return `${day}/${month}/${year}`;
};

export const formatDateTime = (dateString?: string | Date | null): string => {
  const date = parseDate(dateString);
  if (!date) return '-';

  const day = date.getDate().toString().padStart(2, '0');
  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const year = date.getFullYear().toString();
  const hours = date.getHours().toString().padStart(2, '0');
  const minutes = date.getMinutes().toString().padStart(2, '0');

  return `${day}/${month}/${year} ${hours}:${minutes}`;
};

export const toDateInputValue = (dateString?: string | Date | null): string => {
  const date = parseDate(dateString);
  if (!date) return '';

  const year = date.getFullYear().toString();
  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const day = date.getDate().toString().padStart(2, '0');
  return `${year}-${month}-${day}`;
};
