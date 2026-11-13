export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',
  ssr: false, // application 100 % navigateur : plus simple avec les jetons Sanctum
  devtools: { enabled: false },
  css: ['~/assets/css/main.css'],
  runtimeConfig: {
    public: {
      apiBase: 'http://127.0.0.1:8000/api', // adresse de votre backend Laravel
      montantMensuel: 2000, // facture mensuelle en FCFA
    },
  },
  app: {
    head: {
      htmlAttrs: { lang: 'fr' },
      title: 'EcoTri',
      meta: [{ name: 'viewport', content: 'width=device-width, initial-scale=1' }],
      link: [
        { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
        { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' },
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/css2?family=Fustat:wght@600;700;800&family=Manrope:wght@400;500;600;700&display=swap',
        },
      ],
    },
  },
})