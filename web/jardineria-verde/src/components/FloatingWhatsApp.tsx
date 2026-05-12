'use client'

import { useState, useEffect } from 'react'

export default function FloatingWhatsApp() {
  const [isVisible, setIsVisible] = useState(false)
  const [isExpanded, setIsExpanded] = useState(false)

  useEffect(() => {
    const timer = setTimeout(() => {
      setIsVisible(true)
    }, 3000) // Aparece después de 3 segundos

    return () => clearTimeout(timer)
  }, [])

  const handleWhatsAppClick = () => {
    const message = encodeURIComponent('¡Hola PROEXNA! 🌱 Me interesa conocer más sobre sus servicios profesionales de jardinería. ¿Podrían ayudarme?')
    window.open(`https://wa.me/+529513084924?text=${message}`, '_blank')
  }

  const handleToggleExpand = () => {
    setIsExpanded(!isExpanded)
  }

  if (!isVisible) return null

  return (
    <>
      {/* Floating WhatsApp Button */}
      <div className="fixed bottom-6 right-6 z-50">
        <div className="relative">
          {/* Chat Bubble - Solo se muestra cuando está expandido */}
          {isExpanded && (
            <div className="absolute bottom-16 right-0 mb-2 animate-fade-in">
              <div className="bg-white rounded-lg shadow-xl p-4 max-w-xs border border-gray-200">
                <div className="flex items-start space-x-3">
                  <div className="flex-shrink-0">
                    <div className="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                      <span className="text-white text-lg">🌱</span>
                    </div>
                  </div>
                  <div className="flex-1">
                    <p className="text-sm font-semibold text-gray-900">PROEXNA</p>
                    <p className="text-xs text-gray-600 mt-1">
                      ¡Hola! 👋 ¿Te ayudamos con tu proyecto de jardín?
                    </p>
                    <p className="text-xs text-green-600 mt-2 font-medium">
                      Respuesta inmediata por WhatsApp
                    </p>
                  </div>
                  <button
                    onClick={handleToggleExpand}
                    className="text-gray-400 hover:text-gray-600"
                  >
                    ✕
                  </button>
                </div>
                {/* Arrow */}
                <div className="absolute bottom-0 right-4 transform translate-y-full">
                  <div className="w-0 h-0 border-l-8 border-r-8 border-t-8 border-transparent border-t-white"></div>
                </div>
              </div>
            </div>
          )}

          {/* Main WhatsApp Button */}
          <div className="relative">
            {/* Pulse Animation Ring */}
            <div className="absolute inset-0 bg-green-500 rounded-full animate-ping opacity-75"></div>
            <div className="absolute inset-0 bg-green-500 rounded-full animate-pulse opacity-50"></div>

            {/* Button */}
            <button
              onClick={isExpanded ? handleWhatsAppClick : handleToggleExpand}
              className="relative bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-2xl transition-all duration-300 transform hover:scale-110 group"
              title="Contactar por WhatsApp"
            >
              <span className="text-2xl group-hover:scale-110 transition-transform duration-300">
                💬
              </span>

              {/* Notification Badge */}
              <div className="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-bounce">
                1
              </div>

              {/* Tooltip for Desktop */}
              <div className="absolute bottom-full right-0 mb-2 px-3 py-1 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                ¡Chatea con nosotros!
              </div>
            </button>
          </div>
        </div>
      </div>

      {/* Background Overlay cuando está expandido */}
      {isExpanded && (
        <div
          className="fixed inset-0 bg-black bg-opacity-20 z-40"
          onClick={() => setIsExpanded(false)}
        />
      )}
    </>
  )
}