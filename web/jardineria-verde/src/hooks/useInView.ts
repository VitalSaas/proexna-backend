import { useState, useEffect, useRef } from 'react'

export function useInView<T extends Element = HTMLDivElement>(options?: IntersectionObserverInit) {
  const [isInView, setIsInView] = useState(false)
  const [hasBeenInView, setHasBeenInView] = useState(false)
  const ref = useRef<T>(null)

  useEffect(() => {
    const observer = new IntersectionObserver(
      ([entry]) => {
        if (entry.isIntersecting) {
          setIsInView(true)
          setHasBeenInView(true)
        } else {
          setIsInView(false)
        }
      },
      {
        threshold: 0.1,
        ...options,
      }
    )

    const currentElement = ref.current
    if (currentElement) {
      observer.observe(currentElement)
    }

    return () => {
      if (currentElement) {
        observer.unobserve(currentElement)
      }
    }
  }, [options])

  return { ref, isInView, hasBeenInView }
}