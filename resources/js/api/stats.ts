import { request } from './api';
import { ModelCollection } from '@/types';
import Metric from '@/models/Metric';

export async function fetchStats(params = {}): Promise<ModelCollection<Metric>> {
  const { data } = await request('/stats', params);

  data.data = data.data.map((attributes: any) => Metric.create(attributes));

  return data;
}
