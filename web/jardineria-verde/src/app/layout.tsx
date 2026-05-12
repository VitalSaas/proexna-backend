import type { Metadata } from 'next'
import { Inter } from 'next/font/google'
import './globals.css'

const inter = Inter({ subsets: ['latin'] })

export const metadata: Metadata = {
  title: 'Jardinería Verde - Especialistas en Jardines',
  description: 'Transformamos tu espacio exterior en un oasis natural. Servicios profesionales de jardinería, paisajismo y mantenimiento de jardines.',
  keywords: 'jardinería, paisajismo, jardines, plantas, mantenimiento, diseño de exteriores',
}

export default function RootLayout({
  children,
}: {
  children: React.ReactNode
}) {
  return (
    <html lang="es">
      <body className={inter.className}>
        <div className="min-h-screen bg-gradient-to-b from-green-50 to-white">
          {children}
        </div>
      </body>
    </html>
  )
}