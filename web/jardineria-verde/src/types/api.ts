// Hero Section Types
export interface HeroSectionButton {
  text: string;
  url: string;
  type: 'primary' | 'secondary' | 'outline';
  action: 'link' | 'scroll' | 'call' | 'whatsapp' | 'email';
  onClick: string;
}

export interface HeroSectionImage {
  url: string | null;
  position: 'background' | 'left' | 'right' | 'center' | 'none';
  effects: Record<string, string>;
}

export interface HeroSectionGradient {
  position: 'none' | 'top' | 'bottom' | 'left' | 'right' | 'center';
  settings: Record<string, any>;
  css: string | null;
}

export interface HeroSectionContent {
  position: 'center' | 'left' | 'right' | 'top-left' | 'top-right' | 'bottom-left' | 'bottom-right';
  width: number;
}

export interface HeroSection {
  id: number;
  title: string;
  slug: string;
  subtitle: string | null;
  description: string | null;
  image: HeroSectionImage;
  gradient: HeroSectionGradient;
  content: HeroSectionContent;
  buttons: HeroSectionButton[];
  height: number | null;
  sort_order: number;
  // Frontend-friendly properties
  backgroundImage: string;
  imageUrl: string | null;
  gradientOverlay: string | null;
  contentAlignment: {
    justify: string;
    align: string;
  };
  buttonText: string;
  buttonSecondaryText: string;
  cssClasses: string[];
  styles: Record<string, string>;
}

export interface HeroSectionsResponse {
  data: HeroSection[];
  meta: {
    count: number;
    cache_ttl: number;
  };
}

// Service Types
export interface Service {
  id: number;
  title: string;
  short_description: string | null;
  price: string | null;
  formatted_price: string | null;
  price_description: string | null;
  icon: string | null;
  image: string | null;
  category: string;
  category_name: string;
  featured: boolean;
}

export interface ServicesResponse {
  data: Service[];
  meta: {
    count: number;
  };
  filters: {
    categories: Record<string, string>;
  };
}

// Contact Types
export interface ContactConfig {
  service_interests: Record<string, string>;
  validation: Record<string, string[]>;
  contact_info: {
    phone: string;
    whatsapp: string;
    email: string;
    business_name: string;
  };
}

export interface ContactConfigResponse {
  data: ContactConfig;
}

export interface ContactSubmission {
  name: string;
  email: string;
  phone?: string;
  subject?: string;
  message: string;
  service_interest?: string;
}

export interface ContactSubmissionResponse {
  success: boolean;
  message: string;
  data: {
    id: number;
    reference: string;
    status: string;
  };
}

// API Response wrapper
export interface ApiResponse<T> {
  success: boolean;
  data: T;
  message?: string;
  errors?: Record<string, string[]>;
}