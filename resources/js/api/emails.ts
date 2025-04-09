import { request } from './api';
import { EmailRequestParams, ModelCollectionWithPagination } from '@/types';
import Email from '@/models/Email';

export async function fetchEmails(params: EmailRequestParams = {}): Promise<ModelCollectionWithPagination<Email>> {
  const response = await request('/emails', params);

  response.data = response.data.map((attributes: any) => Email.create(attributes));

  return response;
}

export async function fetchEmailPayload(email: any): Promise<string> {
  const id = (email.id ?? email) as string;

  return (await request(`/emails/${id}/payload`)).data;
}
