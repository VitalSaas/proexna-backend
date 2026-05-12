'use client'

import { useState } from 'react'

export default function TopBar() {
  const [isVisible, setIsVisible] = useState(true)

  const contactInfo = {
    phone: '951 308 4924',
    whatsapp: '+529513084924',
    email: 'info@proexna.com',
    schedule: 'Lun-Vie: 8:00-18:00 | Sáb: 9:00-14:00'
  }

  const socialLinks = [
    { name: 'Facebook', icon: '📘', url: 'https://facebook.com/proexna' },
    { name: 'Instagram', icon: '📷', url: 'https://instagram.com/proexna' },
    { name: 'Twitter', icon: '🐦', url: 'https://twitter.com/proexna' },
    { name: 'YouTube', icon: '📺', url: 'https://youtube.com/@proexna' }
  ]

  const handleWhatsAppClick = () => {
    const message = encodeURIComponent('¡Hola PROEXNA! 🌱 Me interesa conocer más sobre sus servicios profesionales de jardinería.')
    window.open(`https://wa.me/${contactInfo.whatsapp}?text=${message}`, '_blank')
  }

  const handlePhoneClick = () => {
    window.open(`tel:${contactInfo.phone}`, '_self')
  }

  const handleEmailClick = () => {
    window.open(`mailto:${contactInfo.email}`, '_self')
  }

  if (!isVisible) return null

  return (
    <div className="fixed top-0 left-0 right-0 bg-gradient-to-r from-green-800 to-green-700 text-white py-2 z-50 relative">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0">

          {/* Left Side - Contact Info */}
          <div className="flex flex-col sm:flex-row sm:items-center sm:space-x-6 space-y-1 sm:space-y-0 text-sm">

            {/* Phone */}
            <button
              onClick={handlePhoneClick}
              className="flex items-center space-x-2 hover:text-green-200 transition-colors duration-300 group"
            >
              <span className="text-base group-hover:scale-110 transition-transform duration-300">📞</span>
              <span className="font-medium">{contactInfo.phone}</span>
            </button>

            {/* Schedule */}
            <div className="flex items-center space-x-2 text-green-100">
              <span className="text-base">🕒</span>
              <span className="text-xs sm:text-sm">{contactInfo.schedule}</span>
            </div>

            {/* Email */}
            <button
              onClick={handleEmailClick}
              className="hidden lg:flex items-center space-x-2 hover:text-green-200 transition-colors duration-300 group"
            >
              <span className="text-base group-hover:scale-110 transition-transform duration-300">✉️</span>
              <span className="text-xs">{contactInfo.email}</span>
            </button>
          </div>

          {/* Right Side - Social Media & WhatsApp */}
          <div className="flex items-center justify-between sm:justify-end space-x-4">

            {/* Social Media Links */}
            <div className="flex items-center space-x-3">
              <span className="text-xs text-green-200 hidden sm:inline">Síguenos:</span>
              <div className="flex space-x-2">
                {socialLinks.map((social) => (
                  <a
                    key={social.name}
                    href={social.url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="text-lg hover:scale-125 transition-transform duration-300 hover:text-green-200"
                    title={social.name}
                  >
                    {social.icon}
                  </a>
                ))}
              </div>
            </div>

            {/* WhatsApp CTA */}
            <button
              onClick={handleWhatsAppClick}
              className="flex items-center space-x-2 bg-green-600 hover:bg-green-500 px-3 py-1 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl group"
            >
              <span className="text-base group-hover:animate-pulse">💬</span>
              <span className="text-xs font-semibold">WhatsApp</span>
            </button>

            {/* Close Button */}
            <button
              onClick={() => setIsVisible(false)}
              className="ml-2 text-green-200 hover:text-white transition-colors duration-300 text-lg hover:scale-110 transform"
              title="Cerrar barra"
            >
              ✕
            </button>
          </div>
        </div>

        {/* Mobile Layout Adjustments */}
        <div className="md:hidden mt-2 pt-2 border-t border-green-600/30">
          <div className="flex items-center justify-between">
            <button
              onClick={handleEmailClick}
              className="flex items-center space-x-2 text-xs text-green-100 hover:text-white transition-colors duration-300"
            >
              <span>✉️</span>
              <span>{contactInfo.email}</span>
            </button>

            <div className="flex items-center space-x-2 text-xs text-green-200">
              <span>📍</span>
              <span>Consulta gratuita disponible</span>
            </div>
          </div>
        </div>
      </div>

      {/* Decorative Elements */}
      <div className="absolute inset-0 bg-gradient-to-r from-transparent via-white/5 to-transparent opacity-20"></div>
    </div>
  )
}