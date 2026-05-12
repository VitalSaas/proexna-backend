import { useState, useEffect } from 'react';
import { apiRequest, endpoints } from '@/lib/api';
import { HeroSection } from '@/types/api';

interface UseHeroSectionsResult {
  heroSections: HeroSection[];
  loading: boolean;
  error: string | null;
  refetch: () => Promise<void>;
}

export function useHeroSections(): UseHeroSectionsResult {
  const [heroSections, setHeroSections] = useState<HeroSection[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const fetchHeroSections = async () => {
    try {
      setLoading(true);
      setError(null);
      const data = await apiRequest<HeroSection[]>(endpoints.heroSections);
      setHeroSections(data);
    } catch (err) {
      const errorMessage = err instanceof Error ? err.message : 'Error desconocido al cargar hero sections';
      setError(errorMessage);
      console.error('Error fetching hero sections:', err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchHeroSections();
  }, []);

  return {
    heroSections,
    loading,
    error,
    refetch: fetchHeroSections,
  };
}