'use client'

import { useInView } from '@/hooks/useInView'

interface ServiceCardProps {
  icon: string;
  title: string;
  description: string;
  features: string[];
  delay?: number;
}

export default function ServiceCard({ icon, title, description, features, delay = 0 }: ServiceCardProps) {
  const { ref, hasBeenInView } = useInView<HTMLDivElement>({ threshold: 0.2 })

  return (
    <div
      ref={ref}
      className={`group relative bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-700 transform ${
        hasBeenInView
          ? 'translate-y-0 opacity-100'
          : 'translate-y-12 opacity-0'
      }`}
      style={{
        transitionDelay: `${delay}ms`
      }}
    >
      {/* Icon with animation */}
      <div className={`text-5xl mb-6 transition-all duration-500 transform group-hover:scale-110 ${
        hasBeenInView ? 'animate-bounce-gentle' : ''
      }`}>
        {icon}
      </div>

      {/* Title */}
      <h3 className="text-xl font-bold text-gray-900 mb-4 group-hover:text-primary transition-colors duration-300">
        {title}
      </h3>

      {/* Description */}
      <p className="text-gray-600 mb-6 leading-relaxed">
        {description}
      </p>

      {/* Features list */}
      <ul className="space-y-2">
        {features.map((feature, index) => (
          <li
            key={index}
            className={`text-sm text-gray-500 flex items-center transition-all duration-300 transform ${
              hasBeenInView ? 'translate-x-0 opacity-100' : 'translate-x-4 opacity-0'
            }`}
            style={{
              transitionDelay: `${delay + (index + 1) * 100}ms`
            }}
          >
            <span className="w-2 h-2 bg-primary rounded-full mr-3 flex-shrink-0 group-hover:bg-secondary transition-colors duration-300"></span>
            <span className="group-hover:text-gray-700 transition-colors duration-300">
              {feature}
            </span>
          </li>
        ))}
      </ul>

      {/* Hover effect overlay */}
      <div className="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
    </div>
  );
}