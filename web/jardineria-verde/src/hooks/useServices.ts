import { useState, useEffect } from 'react';
import { apiRequest, endpoints } from '@/lib/api';
import { Service } from '@/types/api';

interface UseServicesResult {
  services: Service[];
  loading: boolean;
  error: string | null;
  refetch: () => Promise<void>;
}

interface UseServicesOptions {
  featured?: boolean;
  category?: string;
}

export function useServices(options: UseServicesOptions = {}): UseServicesResult {
  const [services, setServices] = useState<Service[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const fetchServices = async () => {
    try {
      setLoading(true);
      setError(null);

      let endpoint = endpoints.services;
      if (options.featured) {
        endpoint = endpoints.servicesFeatured;
      } else if (options.category) {
        endpoint = endpoints.servicesCategory(options.category);
      }

      const data = await apiRequest<Service[]>(endpoint);
      setServices(data);
    } catch (err) {
      const errorMessage = err instanceof Error ? err.message : 'Error desconocido al cargar servicios';
      setError(errorMessage);
      console.error('Error fetching services:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchServices();
  }, [options.featured, options.category]);

  return {
    services,
    loading,
    error,
    refetch: fetchServices,
  };
}

// Hook específico para servicios destacados
export function useFeaturedServices(): UseServicesResult {
  return useServices({ featured: true });
}

// Hook específico para servicios por categoría
export function useServicesByCategory(category: string): UseServicesResult {
  return useServices({ category });
}