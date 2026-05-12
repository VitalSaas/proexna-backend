'use client'

import { useState } from 'react'
import HeroSlider from '@/components/HeroSlider'
import Navigation from '@/components/Navigation'
import ServiceCard from '@/components/ServiceCard'
import TopBar from '@/components/TopBar'
import FloatingWhatsApp from '@/components/FloatingWhatsApp'
import { useFeaturedServices, useServices } from '@/hooks/useServices'
import { useContactSubmission } from '@/hooks/useContact'

export default function Home() {
  const { services: featuredServices, loading: loadingFeatured } = useFeaturedServices()
  const { services: allServices, loading: loadingServices } = useServices()
  const { submitContact, submitting, error: submitError } = useContactSubmission()

  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    message: ''
  })
  const [submitSuccess, setSubmitSuccess] = useState(false)

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    setSubmitSuccess(false)

    try {
      await submitContact({
        name: formData.name,
        email: formData.email,
        phone: formData.phone || undefined,
        message: formData.message,
      })

      setSubmitSuccess(true)
      setFormData({ name: '', email: '', phone: '', message: '' })
    } catch (error) {
      console.error('Error al enviar formulario:', error)
    }
  }

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    })
  }

  return (
    <main>
      {/* Top Contact Bar */}
      <TopBar />

      {/* Sticky Navigation */}
      <Navigation />

      {/* Hero Slider Section */}
      <HeroSlider />

      {/* Servicios */}
      <section id="servicios" className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              Servicios Profesionales PROEXNA
            </h2>
            <p className="text-xl text-gray-600 max-w-3xl mx-auto mb-6">
              Profesionalismo y experiencia en la naturaleza. Ofrecemos servicios integrales de jardinería para crear, mantener y restaurar espacios verdes excepcionales.
            </p>
            <div className="bg-red-50 border border-red-200 rounded-lg p-4 max-w-4xl mx-auto">
              <h3 className="text-lg font-semibold text-red-800 mb-2">⚠️ Problemas Comunes en Áreas Verdes</h3>
              <p className="text-red-700 text-sm leading-relaxed">
                El mal cuidado de un área verde conlleva consecuencias que van desde problemas estéticos y de salud ante el pasto,
                al extremo causando daños graves que son la muerte del pasto. Los errores comunes son: <strong>riego excesivo o insuficiente,
                la falta de nutrientes, el corte incorrecto y la mala atención ante un césped debilitado.</strong>
              </p>
            </div>
          </div>

          {/* Servicio Especializado Destacado */}
          <div className="mb-12 bg-gradient-to-r from-red-600 to-red-500 rounded-2xl p-8 text-white">
            <div className="text-center">
              <div className="text-5xl mb-4">🍄</div>
              <h3 className="text-2xl font-bold mb-4">TRATAMIENTO Y RESTAURACIÓN DE ÁREA VERDE</h3>
              <h4 className="text-xl font-semibold mb-4">POR INVASIÓN DE HONGOS</h4>
              <p className="text-lg text-red-100 max-w-3xl mx-auto">
                Servicio especializado de intervención para áreas verdes afectadas por hongos.
                Diagnóstico profesional, tratamiento específico y restauración completa del área.
              </p>
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {loadingFeatured ? (
              // Loading state
              Array.from({ length: 3 }).map((_, index) => (
                <div key={index} className="bg-white p-6 rounded-lg shadow-lg animate-pulse">
                  <div className="w-12 h-12 bg-gray-300 rounded-full mx-auto mb-4"></div>
                  <div className="h-6 bg-gray-300 rounded mb-4 mx-auto w-3/4"></div>
                  <div className="h-4 bg-gray-300 rounded mb-2"></div>
                  <div className="h-4 bg-gray-300 rounded mb-2"></div>
                  <div className="h-4 bg-gray-300 rounded w-1/2"></div>
                </div>
              ))
            ) : featuredServices.length > 0 ? (
              // Dynamic services from API
              featuredServices.slice(0, 3).map((service, index) => (
                <ServiceCard
                  key={service.id}
                  icon={service.icon || "🌿"}
                  title={service.title}
                  description={service.short_description || ""}
                  features={[
                    service.formatted_price || service.price || "",
                    service.category_name || service.category,
                    "Servicio profesional",
                    "Garantía incluida"
                  ].filter(Boolean)}
                  delay={index * 200}
                />
              ))
            ) : (
              // Fallback hardcoded services if no API data
              <>
                <ServiceCard
                  icon="🌿"
                  title="Diseño y Construcción"
                  description="Diseño de jardines ornamentales y desérticos. Construcción y remodelación de jardines con enfoque profesional."
                  features={[
                    "Jardines ornamentales",
                    "Jardines desérticos",
                    "Construcción y remodelación",
                    "Diseño personalizado"
                  ]}
                  delay={0}
                />

                <ServiceCard
                  icon="🌱"
                  title="Mantenimiento Integral"
                  description="Mantenimientos generales, fertilización, abonado y cuidado especializado de áreas verdes."
                  features={[
                    "Mantenimientos generales",
                    "Fertilización y abonado",
                    "Poda correctiva",
                    "Control de plagas"
                  ]}
                  delay={200}
                />

                <ServiceCard
                  icon="🏡"
                  title="Instalación y Sistemas"
                  description="Instalación de sistemas de riego, sembrado de árboles adultos y palmas, banqueo y reubicación."
                  features={[
                    "Sistemas de riego",
                    "Sembrado de árboles adultos",
                    "Banqueo de árboles y palmas",
                    "Reubicación profesional"
                  ]}
                  delay={400}
                />
              </>
            )}
          </div>

          {/* Lista Completa de Servicios PROEXNA */}
          <div className="mt-16 bg-white rounded-2xl shadow-xl p-8 border border-green-100">
            <h3 className="text-2xl font-bold text-center text-gray-900 mb-8">
              📋 Servicios Completos PROEXNA
            </h3>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              {loadingServices ? (
                // Loading state
                Array.from({ length: 10 }).map((_, index) => (
                  <div key={index} className="flex items-center p-4 bg-green-50 rounded-lg animate-pulse">
                    <div className="w-6 h-6 bg-gray-300 rounded mr-3"></div>
                    <div className="h-4 bg-gray-300 rounded flex-1"></div>
                  </div>
                ))
              ) : allServices.length > 0 ? (
                // Dynamic services from API
                allServices.map((service, index) => (
                  <div
                    key={service.id}
                    className="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-300 group cursor-pointer"
                    title={`${service.title} - ${service.short_description || ''}`}
                  >
                    <span className="text-primary text-lg mr-3 group-hover:scale-110 transition-transform duration-300">
                      {service.icon || "📌"}
                    </span>
                    <div className="flex-1">
                      <span className="text-gray-700 font-medium group-hover:text-green-800 transition-colors duration-300 block">
                        {service.title}
                      </span>
                      {service.formatted_price && (
                        <span className="text-green-600 text-sm font-semibold">
                          {service.formatted_price}
                        </span>
                      )}
                    </div>
                  </div>
                ))
              ) : (
                // Fallback hardcoded services if no API data
                [
                  "📌 Mantenimientos generales",
                  "📌 Instalación de sistema de riegos",
                  "📌 Banqueo ó Reubicación de árboles y palmas",
                  "📌 Diseño de jardines ornamentales y desérticos",
                  "📌 Construcción y Remodelación de jardines",
                  "📌 Fumigación para control de plagas",
                  "📌 Poda correctiva y Derribado de árboles",
                  "📌 Fertilización y Abonado de áreas verdes",
                  "📌 Sembrado de árboles y palmas adultas",
                  "📌 Todo lo que abarca en el ámbito natural"
                ].map((service, index) => (
                  <div
                    key={index}
                    className="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-300 group"
                  >
                    <span className="text-primary text-lg mr-3 group-hover:scale-110 transition-transform duration-300">
                      {service.split(' ')[0]}
                    </span>
                    <span className="text-gray-700 font-medium group-hover:text-green-800 transition-colors duration-300">
                      {service.substring(2)}
                    </span>
                  </div>
                ))
              )}
            </div>

            <div className="mt-8 text-center">
              <p className="text-lg font-bold text-green-800 mb-4">
                PROFESIONALISMO Y EXPERIENCIA EN LA NATURALEZA
              </p>
              <p className="text-2xl font-bold text-primary">
                PROEXNA CERCA DE TI
              </p>
              <div className="mt-4 flex justify-center space-x-4">
                <button
                  onClick={() => window.open('tel:+529513084924', '_self')}
                  className="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 flex items-center space-x-2"
                >
                  <span>📞</span>
                  <span>951 308 4924</span>
                </button>
                <button
                  onClick={() => {
                    const message = encodeURIComponent('¡Hola PROEXNA! 🌱 Me interesa conocer más sobre sus servicios profesionales de jardinería.')
                    window.open(`https://wa.me/+529513084924?text=${message}`, '_blank')
                  }}
                  className="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 flex items-center space-x-2"
                >
                  <span>💬</span>
                  <span>WhatsApp</span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Sobre Nosotros */}
      <section id="nosotros" className="py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
              <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                Más de 15 años creando espacios verdes
              </h2>
              <p className="text-lg text-gray-600 mb-6">
                En Jardinería Verde somos especialistas en transformar espacios exteriores en verdaderos oasis naturales.
                Nuestro equipo de profesionales combina experiencia, creatividad y pasión por la naturaleza.
              </p>
              <div className="space-y-4">
                <div className="flex items-center">
                  <span className="text-primary text-xl mr-3">✓</span>
                  <span className="text-gray-700">Equipo certificado de jardineros</span>
                </div>
                <div className="flex items-center">
                  <span className="text-primary text-xl mr-3">✓</span>
                  <span className="text-gray-700">Garantía en todos nuestros trabajos</span>
                </div>
                <div className="flex items-center">
                  <span className="text-primary text-xl mr-3">✓</span>
                  <span className="text-gray-700">Presupuestos sin compromiso</span>
                </div>
              </div>
            </div>
            <div className="bg-primary/10 rounded-lg p-8">
              <div className="text-6xl mb-4 text-center">🌳</div>
              <div className="grid grid-cols-2 gap-8 text-center">
                <div>
                  <div className="text-3xl font-bold text-primary mb-2">500+</div>
                  <div className="text-gray-600">Jardines creados</div>
                </div>
                <div>
                  <div className="text-3xl font-bold text-primary mb-2">15+</div>
                  <div className="text-gray-600">Años experiencia</div>
                </div>
                <div>
                  <div className="text-3xl font-bold text-primary mb-2">100%</div>
                  <div className="text-gray-600">Clientes satisfechos</div>
                </div>
                <div>
                  <div className="text-3xl font-bold text-primary mb-2">24/7</div>
                  <div className="text-gray-600">Soporte técnico</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Contacto */}
      <section id="contacto" className="py-20 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
              ¿Listo para transformar tu jardín?
            </h2>
            <p className="text-xl text-gray-600">
              Contacta con nosotros y recibe una consulta gratuita
            </p>
          </div>

          <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {/* Información de contacto */}
            <div>
              <h3 className="text-2xl font-bold text-gray-900 mb-6">Información de Contacto</h3>
              <div className="space-y-6">
                <div className="flex items-start">
                  <span className="text-2xl mr-4">📍</span>
                  <div>
                    <h4 className="font-semibold text-gray-900">Dirección</h4>
                    <p className="text-gray-600">Calle Jardín Verde 123, Ciudad, País</p>
                  </div>
                </div>

                <div className="flex items-start">
                  <span className="text-2xl mr-4">📞</span>
                  <div className="flex-1">
                    <h4 className="font-semibold text-gray-900">Teléfono</h4>
                    <div className="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0">
                      <a
                        href="tel:+529513084924"
                        className="text-primary hover:text-secondary font-medium transition-colors duration-300 text-lg"
                      >
                        951 308 4924
                      </a>
                      <button
                        onClick={() => {
                          const message = encodeURIComponent('¡Hola PROEXNA! 🌱 Me interesa recibir información sobre sus servicios profesionales de jardinería.')
                          window.open(`https://wa.me/+529513084924?text=${message}`, '_blank')
                        }}
                        className="inline-flex items-center space-x-2 bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-full text-sm transition-all duration-300 transform hover:scale-105"
                      >
                        <span>💬</span>
                        <span>WhatsApp</span>
                      </button>
                    </div>
                  </div>
                </div>

                <div className="flex items-start">
                  <span className="text-2xl mr-4">✉️</span>
                  <div>
                    <h4 className="font-semibold text-gray-900">Email</h4>
                    <a
                      href="mailto:info@proexna.com"
                      className="text-primary hover:text-secondary transition-colors duration-300"
                    >
                      info@proexna.com
                    </a>
                  </div>
                </div>

                <div className="flex items-start">
                  <span className="text-2xl mr-4">🕒</span>
                  <div>
                    <h4 className="font-semibold text-gray-900">Horario</h4>
                    <p className="text-gray-600">Lun - Vie: 8:00 - 18:00<br />Sáb: 9:00 - 14:00</p>
                  </div>
                </div>

                {/* Métodos de Contacto Rápido */}
                <div className="bg-green-50 p-4 rounded-lg border border-green-100">
                  <h4 className="font-semibold text-gray-900 mb-3">Contacto Rápido</h4>
                  <div className="grid grid-cols-2 gap-3">
                    <button
                      onClick={() => window.open('tel:+529513084924', '_self')}
                      className="flex items-center justify-center space-x-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-3 rounded-lg transition-all duration-300 transform hover:scale-105 text-sm"
                    >
                      <span>📞</span>
                      <span>Llamar</span>
                    </button>
                    <button
                      onClick={() => {
                        const message = encodeURIComponent('¡Hola PROEXNA! 🌱 Necesito una cotización para mi jardín.')
                        window.open(`https://wa.me/+529513084924?text=${message}`, '_blank')
                      }}
                      className="flex items-center justify-center space-x-2 bg-green-500 hover:bg-green-600 text-white py-2 px-3 rounded-lg transition-all duration-300 transform hover:scale-105 text-sm"
                    >
                      <span>💬</span>
                      <span>WhatsApp</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            {/* Formulario */}
            <div className="bg-white p-8 rounded-lg shadow-lg">
              {submitSuccess && (
                <div className="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                  <div className="flex items-center">
                    <span className="text-green-600 text-xl mr-3">✅</span>
                    <div>
                      <h4 className="text-green-800 font-semibold">¡Mensaje enviado exitosamente!</h4>
                      <p className="text-green-700 text-sm">Te responderemos pronto.</p>
                    </div>
                  </div>
                </div>
              )}

              {submitError && (
                <div className="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                  <div className="flex items-center">
                    <span className="text-red-600 text-xl mr-3">❌</span>
                    <div>
                      <h4 className="text-red-800 font-semibold">Error al enviar el mensaje</h4>
                      <p className="text-red-700 text-sm">{submitError}</p>
                    </div>
                  </div>
                </div>
              )}

              <form onSubmit={handleSubmit} className="space-y-6">
                <div>
                  <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-2">
                    Nombre completo
                  </label>
                  <input
                    type="text"
                    id="name"
                    name="name"
                    required
                    value={formData.name}
                    onChange={handleChange}
                    className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                    placeholder="Tu nombre"
                  />
                </div>

                <div>
                  <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-2">
                    Email
                  </label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    value={formData.email}
                    onChange={handleChange}
                    className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                    placeholder="tu@email.com"
                  />
                </div>

                <div>
                  <label htmlFor="phone" className="block text-sm font-medium text-gray-700 mb-2">
                    Teléfono
                  </label>
                  <input
                    type="tel"
                    id="phone"
                    name="phone"
                    value={formData.phone}
                    onChange={handleChange}
                    className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                    placeholder="+1 234 567 8900"
                  />
                </div>

                <div>
                  <label htmlFor="message" className="block text-sm font-medium text-gray-700 mb-2">
                    Mensaje
                  </label>
                  <textarea
                    id="message"
                    name="message"
                    required
                    rows={4}
                    value={formData.message}
                    onChange={handleChange}
                    className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                    placeholder="Cuéntanos sobre tu proyecto de jardín..."
                  />
                </div>

                <button
                  type="submit"
                  disabled={submitting}
                  className="w-full btn-primary disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center space-x-2"
                >
                  {submitting ? (
                    <>
                      <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                      <span>Enviando...</span>
                    </>
                  ) : (
                    <span>Enviar Mensaje</span>
                  )}
                </button>
              </form>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-gray-900 text-white py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div className="col-span-2">
              <h3 className="text-2xl font-bold mb-4">🌱 PROEXNA</h3>
              <p className="text-gray-400 mb-4">
                Profesionalismo y experiencia en la naturaleza. Servicios integrales de jardinería profesional,
                desde mantenimientos generales hasta tratamientos especializados por invasión de hongos.
              </p>
              <div className="flex space-x-4">
                <a href="https://facebook.com/proexna" target="_blank" rel="noopener noreferrer" className="text-2xl cursor-pointer hover:text-primary transition-colors duration-300">📘</a>
                <a href="https://instagram.com/proexna" target="_blank" rel="noopener noreferrer" className="text-2xl cursor-pointer hover:text-primary transition-colors duration-300">📷</a>
                <a href="https://twitter.com/proexna" target="_blank" rel="noopener noreferrer" className="text-2xl cursor-pointer hover:text-primary transition-colors duration-300">🐦</a>
              </div>
            </div>

            <div>
              <h4 className="text-lg font-semibold mb-4">Servicios Principales</h4>
              <ul className="space-y-2 text-gray-400">
                <li><a href="#servicios" className="hover:text-white">Tratamiento de Hongos</a></li>
                <li><a href="#servicios" className="hover:text-white">Mantenimiento Integral</a></li>
                <li><a href="#servicios" className="hover:text-white">Sistemas de Riego</a></li>
                <li><a href="#servicios" className="hover:text-white">Banqueo de Árboles</a></li>
                <li><a href="#servicios" className="hover:text-white">Poda Correctiva</a></li>
              </ul>
            </div>

            <div>
              <h4 className="text-lg font-semibold mb-4">Contacto</h4>
              <ul className="space-y-2 text-gray-400">
                <li>📍 Servicio a domicilio</li>
                <li>
                  <a href="tel:+529513084924" className="hover:text-white transition-colors duration-300">
                    📞 951 308 4924
                  </a>
                </li>
                <li>
                  <a href="mailto:info@proexna.com" className="hover:text-white transition-colors duration-300">
                    ✉️ info@proexna.com
                  </a>
                </li>
                <li className="text-green-400 font-semibold">PROEXNA CERCA DE TI</li>
              </ul>
            </div>
          </div>

          <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2024 PROEXNA - Profesionalismo y Experiencia en la Naturaleza. Todos los derechos reservados.</p>
          </div>
        </div>
      </footer>

      {/* Floating WhatsApp Button */}
      <FloatingWhatsApp />
    </main>
  )
}