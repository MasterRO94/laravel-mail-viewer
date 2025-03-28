import { request } from './api';
import { ModelCollectionWithPagination } from '@/types';
import Email from '@/models/Email';

export async function fetchEmails(params = {}): Promise<ModelCollectionWithPagination<Email>> {
  const { data } = await request('/emails', params);

  data.data = data.data.map((attributes: any) => Email.create(attributes));

  return data;
}

export async function fetchEmailPayload(email: any): Promise<string> {
  const id = (email.id ?? email) as string;

  return (await request(`/emails/${id}/payload`)).data;
}
