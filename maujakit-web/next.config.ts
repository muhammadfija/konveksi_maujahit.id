import type { NextConfig } from "next";

const nextConfig: NextConfig = {
  allowedDevOrigins: ['127.0.0.1', '[::1]', 'localhost'],
  images: {
    remotePatterns: [
      // Lokal (development)
      {
        protocol: 'http',
        hostname: 'localhost',
        port: '8000',
        pathname: '/storage/**',
      },
      // Railway (production backend)
      {
        protocol: 'https',
        hostname: '*.up.railway.app',
        pathname: '/storage/**',
      },
      // Jika pakai custom domain sendiri
      {
        protocol: 'https',
        hostname: '*.maujahit.id',
        pathname: '/storage/**',
      },
    ],
  },
};

export default nextConfig;
