'use client'

import { useState, useEffect } from 'react'

export default function Navigation() {
  const [isScrolled, setIsScrolled] = useState(false)
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false)
  const [activeSection, setActiveSection] = useState('home')

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50)

      // Detectar sección activa
      const sections = ['home', 'servicios', 'nosotros', 'contacto']
      const scrollPosition = window.scrollY + 100

      for (const section of sections) {
        if (section === 'home' && scrollPosition < 300) {
          setActiveSection('home')
          break
        } else if (section !== 'home') {
          const element = document.getElementById(section)
          if (element) {
            const offsetTop = element.offsetTop
            const height = element.offsetHeight
            if (scrollPosition >= offsetTop && scrollPosition < offsetTop + height) {
              setActiveSection(section)
              break
            }
          }
        }
      }
    }

    window.addEventListener('scroll', handleScroll)
    return () => window.removeEventListener('scroll', handleScroll)
  }, [])

  const scrollToSection = (sectionId: string) => {
    if (sectionId === 'home') {
      window.scrollTo({ top: 0, behavior: 'smooth' })
    } else {
      const element = document.getElementById(sectionId)
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' })
      }
    }
    setIsMobileMenuOpen(false)
  }

  const navItems = [
    { id: 'home', label: 'Inicio' },
    { id: 'servicios', label: 'Servicios' },
    { id: 'nosotros', label: 'Nosotros' },
    { id: 'contacto', label: 'Contacto' }
  ]

  return (
    <header
      className={`fixed left-0 right-0 z-40 transition-all duration-300 ${
        isScrolled
          ? 'top-0 bg-white/95 backdrop-blur-md shadow-lg'
          : 'top-16 bg-transparent'
      }`}
    >
      <nav className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center py-4">
          {/* Logo */}
          <div className="flex items-center">
            <button
              onClick={() => scrollToSection('home')}
              className="flex items-center space-x-2 transition-all duration-300 hover:scale-105 group"
            >
              <div className={`transition-all duration-300 group-hover:scale-110 ${
                isScrolled ? 'text-2xl' : 'text-3xl'
              }`}>🌱</div>
              <h1 className={`font-bold transition-all duration-300 ${
                isScrolled
                  ? 'text-xl text-gray-900 group-hover:text-primary'
                  : 'text-2xl text-white group-hover:text-green-100'
              }`}>
                PROEXNA
              </h1>
            </button>
          </div>

          {/* Desktop Navigation */}
          <div className="hidden md:block">
            <div className="ml-10 flex items-center space-x-8">
              {navItems.map((item) => (
                <button
                  key={item.id}
                  onClick={() => scrollToSection(item.id)}
                  className={`px-4 py-2 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 relative ${
                    activeSection === item.id
                      ? isScrolled
                        ? 'text-primary bg-green-50 border-b-2 border-primary'
                        : 'text-white bg-white/20 backdrop-blur-sm border-b-2 border-white'
                      : isScrolled
                      ? 'text-gray-700 hover:text-primary hover:bg-green-50'
                      : 'text-white/90 hover:text-white hover:bg-white/10 backdrop-blur-sm'
                  }`}
                >
                  {item.label}
                </button>
              ))}

              <button
                onClick={() => scrollToSection('contacto')}
                className={`px-6 py-2 rounded-lg font-bold transition-all duration-300 transform hover:scale-105 ${
                  isScrolled
                    ? 'bg-primary text-white hover:bg-secondary shadow-md hover:shadow-lg'
                    : 'bg-white/20 text-white hover:bg-white hover:text-primary backdrop-blur-sm border border-white/30'
                }`}
              >
                Contáctanos
              </button>
            </div>
          </div>

          {/* Mobile menu button */}
          <div className="md:hidden">
            <button
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
              className={`p-2 rounded-lg transition-all duration-300 ${
                isScrolled
                  ? 'text-gray-700 hover:bg-gray-100'
                  : 'text-white hover:bg-white/10 backdrop-blur-sm'
              }`}
              aria-label="Toggle menu"
            >
              <div className="w-6 h-6 flex flex-col justify-center items-center">
                <span
                  className={`block w-6 h-0.5 bg-current transition-all duration-300 transform ${
                    isMobileMenuOpen ? 'rotate-45 translate-y-0.5' : '-translate-y-1'
                  }`}
                />
                <span
                  className={`block w-6 h-0.5 bg-current transition-opacity duration-300 ${
                    isMobileMenuOpen ? 'opacity-0' : 'opacity-100'
                  }`}
                />
                <span
                  className={`block w-6 h-0.5 bg-current transition-all duration-300 transform ${
                    isMobileMenuOpen ? '-rotate-45 -translate-y-0.5' : 'translate-y-1'
                  }`}
                />
              </div>
            </button>
          </div>
        </div>

        {/* Mobile Navigation Menu */}
        <div
          className={`md:hidden transition-all duration-300 overflow-hidden ${
            isMobileMenuOpen
              ? 'max-h-96 pb-6'
              : 'max-h-0'
          }`}
        >
          <div className={`space-y-4 ${
            isScrolled
              ? 'bg-white/95 backdrop-blur-md rounded-lg p-4 mt-2'
              : 'bg-white/10 backdrop-blur-sm rounded-lg p-4 mt-2'
          }`}>
            {navItems.map((item, index) => (
              <button
                key={item.id}
                onClick={() => scrollToSection(item.id)}
                className={`block w-full text-left px-4 py-3 rounded-lg font-medium transition-all duration-300 transform hover:scale-105 ${
                  activeSection === item.id
                    ? isScrolled
                      ? 'text-primary bg-green-100 border-l-4 border-primary'
                      : 'text-white bg-white/30 border-l-4 border-white'
                    : isScrolled
                    ? 'text-gray-700 hover:text-primary hover:bg-green-50'
                    : 'text-white hover:bg-white/20'
                }`}
                style={{ animationDelay: `${index * 0.1}s` }}
              >
                {item.label}
              </button>
            ))}

            <button
              onClick={() => scrollToSection('contacto')}
              className={`w-full px-6 py-3 rounded-lg font-bold transition-all duration-300 transform hover:scale-105 ${
                isScrolled
                  ? 'bg-primary text-white hover:bg-secondary'
                  : 'bg-white text-primary hover:bg-white/90'
              }`}
            >
              Contáctanos
            </button>
          </div>
        </div>
      </nav>
    </header>
  )
}