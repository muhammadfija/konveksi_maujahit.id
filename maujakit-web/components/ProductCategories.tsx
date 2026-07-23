'use client';

import { useState, useRef } from 'react';

type Category = {
  id: string;
  name: string;
  images: string[];
};

const categories: Category[] = [
  { id: 'tas', name: 'Tas', images: [
    'https://maujahit.com/storage/products/01KAD0DK6F8S0B4EQK248TCNKF.jpg',
    'https://maujahit.com/storage/products/01KAD0GVC0YPA6K47Y0CCWAADR.jpg',
    'https://maujahit.com/storage/products/01KAD15TJA5EYYMKX1VKAZ7S6R.png',
    'https://maujahit.com/storage/products/01KAD16CNPBRH7RHXZ8TY49JR3.png'
  ]},
  { id: 'kemeja', name: 'Kemeja', images: [
    'https://maujahit.com/storage/products/01KADFTHXGYWNVZMTPCQVJQ189.png',
    'https://maujahit.com/storage/products/01KADFVANZC48VZQQMG5VM9CJ1.png',
    'https://maujahit.com/storage/products/01KADFVXJ4CVM85XY25CHC7S3H.png',
    'https://maujahit.com/storage/products/01KADFWJ97ENKVF0BVV1F4AVQ9.png',
    'https://maujahit.com/storage/products/01KA8MZYCXY5Q5W4FWMDSZYF85.png',
    'https://maujahit.com/storage/products/01KA8MFS2YVHKVF314JDBXA89S.png',
    'https://maujahit.com/storage/products/01KA8MJCD8B6G5SKQP2P9DSYYV.png',
    'https://maujahit.com/storage/products/01KA8MM4187DY19R13Z010X73W.png'
  ]},
  { id: 'rompi', name: 'Rompi', images: [
    'https://maujahit.com/storage/products/01KA8KPPJT87HX0V4KN4540FMA.png',
    'https://maujahit.com/storage/products/01KA8KR6TXZJW9KEGQY8X7Z1RD.png',
    'https://maujahit.com/storage/products/01KA8JWRQHGZ2CSZQMM0K29QGE.png',
    'https://maujahit.com/storage/products/01KA8JXNC65BCM2QXNXQCM7MAM.png',
    'https://maujahit.com/storage/products/01KA8K1G9D10PBXT8N70GNSYC3.png',
    'https://maujahit.com/storage/products/01KA8MB4ZHA7B056NH35ED4K29.png'
  ]},
  { id: 'jaket', name: 'Jaket', images: [
    'https://maujahit.com/storage/products/01KA8C91QJ79C6DQF6356EVDQV.png',
    'https://maujahit.com/storage/products/01KA8CACHF7V6ZMHTA110W0DMX.png',
    'https://maujahit.com/storage/products/01KA8CB06MW6T8ZKSVR6J9JGCM.png',
    'https://maujahit.com/storage/products/01KA8CBNCHA1KMD26MYSB1XVMJ.png',
    'https://maujahit.com/storage/products/01KA8CDMYZ7TPM3BV0RBT7Q018.png',
    'https://maujahit.com/storage/products/01KA8CDZFZ4Y89NCJV1N0A5G41.png',
    'https://maujahit.com/storage/products/01KA8CE94YN1KS4KKQ9Q2MS0G6.png',
    'https://maujahit.com/storage/products/01KA8CER47YRN789D2G8MDQACR.png'
  ]},
  { id: 'kaos_pendek', name: 'Kaos Pendek', images: [
    'https://maujahit.com/storage/products/01KA7YD7GJSSGN7EFX46MCZ2M9.png',
    'https://maujahit.com/storage/products/01KA7ZD818Q856VS9E2HET9SMD.png',
    'https://maujahit.com/storage/products/01KA7ZN64SRBDC3THQMRJDFMES.png',
    'https://maujahit.com/storage/products/01KA89PX4Q7T5H1VANGF9QZARE.png',
    'https://maujahit.com/storage/products/01KA89N027GJKXFRM03TSBHAR2.png',
    'https://maujahit.com/storage/products/01KA89TE9KG59SKAASZ75ZY9MG.png',
    'https://maujahit.com/storage/products/01KA89Z5RFYT1GGFJVFCBMS81Q.png'
  ]},
  { id: 'jersey', name: 'Jersey', images: [
    'https://maujahit.com/storage/products/01KA7XKZYMHWXMPGDZAV25TGMG.png',
    'https://maujahit.com/storage/products/01KA7X78XV88HYA5G5FQNPVZGT.png',
    'https://maujahit.com/storage/products/01KA7XWC53AZMFFT21TJEXH7WX.png',
    'https://maujahit.com/storage/products/01KA7XY3H6JQF1WCES6PNNGERM.png',
    'https://maujahit.com/storage/products/01KA7Y02Z17TT0HJ68X6YMJRYE.png',
    'https://maujahit.com/storage/products/01KA7Y0FB9VZPV36QVDXMK2E9C.png',
    'https://maujahit.com/storage/products/01KA7Y1KWRRB91MXYVFTA1K4ZB.png'
  ]},
  { id: 'polo', name: 'Polo Shirt', images: [
    'https://maujahit.com/storage/products/01KA8N6XZ88YQH3PDDX01S98HJ.png',
    'https://maujahit.com/storage/products/01KA7WGFK6VY4YGHWHCN8MD75C.jpeg',
    'https://maujahit.com/storage/products/01KA7X6A8RGTWTYRAPZD9W9001.jpeg',
    'https://maujahit.com/storage/products/01KA7XGP05YT616SC7VVMHMJ37.jpeg'
  ]},
  { id: 'kaos_panjang', name: 'Kaos Panjang', images: [
    'https://maujahit.com/storage/products/01KA7WJ96NX3AYFR4KPVG2YGNW.jpeg',
    'https://maujahit.com/storage/products/01KA7WM8YRAP6WQMVYZTVYT32F.jpeg',
    'https://maujahit.com/storage/products/01KA81DQTHZQAB66KW9Q35Q6J2.jpg',
    'https://maujahit.com/storage/products/01KA8248B5D1MEJSDXG1GB2Q53.png',
    'https://maujahit.com/storage/products/01KA828BK6QYFJF5316P9GSGE2.png'
  ]}
];

export default function ProductCategories() {
  const [activeTab, setActiveTab] = useState<string>(categories[0].id);
  const sliderRef = useRef<HTMLDivElement>(null);

  const scrollPrev = () => {
    if (sliderRef.current) {
      sliderRef.current.scrollBy({ left: -300, behavior: 'smooth' });
    }
  };

  const scrollNext = () => {
    if (sliderRef.current) {
      sliderRef.current.scrollBy({ left: 300, behavior: 'smooth' });
    }
  };

  const activeImages = categories.find((c) => c.id === activeTab)?.images || [];

  return (
    <section className="py-24 bg-gray-50 relative overflow-hidden">
      {/* Background decorations */}
      <div className="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div className="absolute -top-[20%] -right-[10%] w-[50%] h-[50%] rounded-full bg-blue-100/50 blur-3xl" />
        <div className="absolute -bottom-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-indigo-100/50 blur-3xl" />
      </div>

      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div className="text-center mb-16">
          <h2 className="text-3xl lg:text-4xl font-black text-[#0d1f3c] mb-4">
            Kategori Produk
          </h2>
          <p className="text-gray-500 text-lg max-w-2xl mx-auto">
            Temukan berbagai pilihan produk berkualitas yang siap kami produksi untuk kebutuhan Anda.
          </p>
        </div>

        {/* Tabs */}
        <div className="flex flex-wrap justify-center gap-2 mb-12">
          {categories.map((category) => (
            <button
              key={category.id}
              onClick={() => setActiveTab(category.id)}
              className={`px-6 py-2.5 rounded-full text-sm font-bold transition-all duration-300 ${
                activeTab === category.id
                  ? 'bg-[#1e3a6e] text-white shadow-lg shadow-blue-900/20 scale-105'
                  : 'bg-white text-gray-600 hover:bg-gray-100 hover:text-[#1e3a6e] border border-gray-200'
              }`}
            >
              {category.name}
            </button>
          ))}
        </div>

        {/* Slider Container */}
        <div className="relative group">
          {/* Navigation Buttons */}
          <button
            onClick={scrollPrev}
            className="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center bg-white/90 backdrop-blur text-[#1e3a6e] rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity disabled:opacity-0 hover:bg-[#1e3a6e] hover:text-white"
            aria-label="Previous image"
          >
            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 19l-7-7 7-7" />
            </svg>
          </button>

          <button
            onClick={scrollNext}
            className="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 flex items-center justify-center bg-white/90 backdrop-blur text-[#1e3a6e] rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity disabled:opacity-0 hover:bg-[#1e3a6e] hover:text-white"
            aria-label="Next image"
          >
            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 5l7 7-7 7" />
            </svg>
          </button>

          {/* Slider */}
          <div
            ref={sliderRef}
            className="flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide pb-8 pt-4 px-4 -mx-4"
            style={{ scrollbarWidth: 'none', msOverflowStyle: 'none' }}
          >
            {activeImages.map((imgUrl, index) => (
              <div
                key={`${activeTab}-${index}`}
                className="flex-none w-[280px] sm:w-[320px] md:w-[380px] snap-center"
              >
                <div className="relative aspect-[4/5] rounded-3xl overflow-hidden bg-white shadow-xl shadow-gray-200/50 group/card">
                  {/* Next.js Image component needs configured domains, so we use standard img for external URLs if not configured, but wait, if we use next/image it will throw error for unconfigured host. So let's use standard <img> tags for simplicity since we don't know if maujahit.com is in next.config.mjs */}
                  <img
                    src={imgUrl}
                    alt={`Produk ${index + 1}`}
                    className="w-full h-full object-cover transition-transform duration-700 group-hover/card:scale-110"
                    loading="lazy"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-[#0d1f3c]/80 via-transparent to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-300 flex items-end p-6">
                    <span className="text-white font-medium bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm">
                      Lihat Detail
                    </span>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  );
}
