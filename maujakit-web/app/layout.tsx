import type { Metadata } from "next";
import { Inter } from "next/font/google";
import "./globals.css";

const inter = Inter({
  variable: "--font-inter",
  subsets: ["latin"],
  weight: ["300", "400", "500", "600", "700", "800"],
});

export const metadata: Metadata = {
  title: {
    default: "MauJahit.id — Tracking Produksi Pakaian Real-Time",
    template: "%s | MauJahit.id",
  },
  description:
    "MauJahit.id adalah vendor konveksi terpercaya. Pantau progres produksi pakaian Anda secara real-time dengan sistem tracking canggih kami.",
  keywords: ["konveksi", "pakaian", "tracking produksi", "vendor clothing", "MauJahit"],
  authors: [{ name: "MauJahit.id" }],
  openGraph: {
    title: "MauJahit.id — Vendor Konveksi Terpercaya",
    description: "Pantau progres produksi pakaian Anda secara real-time",
    type: "website",
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="id">
      <body className={`${inter.variable} font-sans antialiased`}>
        {children}
      </body>
    </html>
  );
}
