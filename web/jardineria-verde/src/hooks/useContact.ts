import { useState } from 'react';
import { apiRequest, endpoints } from '@/lib/api';
import { ContactConfig, ContactSubmission, ContactSubmissionResponse } from '@/types/api';

interface UseContactConfigResult {
  config: ContactConfig | null;
  loading: boolean;
  error: string | null;
  refetch: () => Promise<void>;
}

interface UseContactSubmissionResult {
  submitContact: (data: ContactSubmission) => Promise<ContactSubmissionResponse>;
  submitting: boolean;
  error: string | null;
}

export function useContactConfig(): UseContactConfigResult {
  const [config, setConfig] = useState<ContactConfig | null>(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const fetchConfig = async () => {
    try {
      setLoading(true);
      setError(null);
      const data = await apiRequest<ContactConfig>(endpoints.contactConfig);
      setConfig(data);
    } catch (err) {
      const errorMessage = err instanceof Error ? err.message : 'Error al cargar configuración de contacto';
      setError(errorMessage);
      console.error('Error fetching contact config:', err);
    } finally {
      setLoading(false);
    }
  };

  return {
    config,
    loading,
    error,
    refetch: fetchConfig,
  };
}

export function useContactSubmission(): UseContactSubmissionResult {
  const [submitting, setSubmitting] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const submitContact = async (data: ContactSubmission): Promise<ContactSubmissionResponse> => {
    try {
      setSubmitting(true);
      setError(null);

      const response = await fetch(`${process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api'}${endpoints.contact}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      });

      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const result = await response.json();

      if (!result.success) {
        throw new Error(result.message || 'Error al enviar el mensaje');
      }

      return result;
    } catch (err) {
      const errorMessage = err instanceof Error ? err.message : 'Error desconocido al enviar mensaje';
      setError(errorMessage);
      throw new Error(errorMessage);
    } finally {
      setSubmitting(false);
    }
  };

  return {
    submitContact,
    submitting,
    error,
  };
}