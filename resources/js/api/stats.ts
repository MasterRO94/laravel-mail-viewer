import { request } from './api';
import { ModelCollection } from '@/types';
import Metric from '@/models/Metric';

export async function fetchStats(params = {}): Promise<ModelCollection<Metric>> {
  const response = await request('/stats', params);

  response.data = response.data.map((attributes: any) => Metric.create(attributes));

  return response;
}
