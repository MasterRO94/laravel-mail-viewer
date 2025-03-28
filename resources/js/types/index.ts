
export interface Pagination {
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
  from: number;
  to: number;
}

export type ModelCollection<T> = {
  data: T[];
}

export type ModelCollectionWithPagination<T> = ModelCollection<T> & Pagination;

export interface Recipient {
  name?: string;
  email: string;
}

export type RecipientEmailField = 'from' | 'to' | 'cc' | 'bcc';
