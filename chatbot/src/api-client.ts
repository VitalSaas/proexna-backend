import axios, { type AxiosInstance } from 'axios';
import { config } from './config.js';
import type {
  Project,
  Sector,
  Testimonial,
  Vacancy,
  StatItem,
  WhyChooseUsItem,
  Post,
  CompanyInfo,
  ProspectPayload,
  ProspectResponse,
} from './types.js';

const client: AxiosInstance = axios.create({
  baseURL: `${config.apiUrl}/api/chatbot`,
  timeout: 10_000,
  headers: { Accept: 'application/json' },
});

export async function getProjects(): Promise<Project[]> {
  const { data } = await client.get<Project[]>('/projects');
  return data;
}

export async function getSectors(): Promise<Sector[]> {
  const { data } = await client.get<Sector[]>('/sectors');
  return data;
}

export async function getTestimonials(): Promise<Testimonial[]> {
  const { data } = await client.get<Testimonial[]>('/testimonials');
  return data;
}

export async function getVacancies(): Promise<Vacancy[]> {
  const { data } = await client.get<Vacancy[]>('/vacancies');
  return data;
}

export async function getStats(): Promise<StatItem[]> {
  const { data } = await client.get<StatItem[]>('/stats');
  return data;
}

export async function getWhyChooseUs(): Promise<WhyChooseUsItem[]> {
  const { data } = await client.get<WhyChooseUsItem[]>('/why-choose-us');
  return data;
}

export async function getPosts(): Promise<Post[]> {
  const { data } = await client.get<Post[]>('/posts');
  return data;
}

export async function getCompany(): Promise<CompanyInfo> {
  const { data } = await client.get<CompanyInfo>('/company');
  return data;
}

export async function createProspect(payload: ProspectPayload): Promise<ProspectResponse> {
  const { data } = await client.post<ProspectResponse>('/prospects', payload);
  return data;
}
