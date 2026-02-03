
export interface Pagination {
  hasMoreItems: boolean;
  perPage: number;
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

export interface EmailRequestParams {
  search?: string;
  startDate?: string;
  endDate?: string;
  oldestId?: number;
  latestId?: number;
}
