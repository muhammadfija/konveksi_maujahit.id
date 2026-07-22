'use client';

import { useState, useEffect } from 'react';
import { TimelineItem } from '@/lib/types';

interface ProductionTimelineProps {
  timeline: TimelineItem[];
  progressPercentage: number;
}

export default function ProductionTimeline({ timeline, progressPercentage }: ProductionTimelineProps) {
  const [lightboxUrl, setLightboxUrl] = useState<string | null>(null);

  // Close lightbox on escape key
  useEffect(() => {
    const handleKeyDown = (e: KeyboardEvent) => {
      if (e.key === 'Escape') setLightboxUrl(null);
    };
    if (lightboxUrl) {
      document.addEventListener('keydown', handleKeyDown);
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = 'unset';
    }
    return () => {
      document.removeEventListener('keydown', handleKeyDown);
      document.body.style.overflow = 'unset';
    };
  }, [lightboxUrl]);
  return (
    <div>
      {/* Progress bar */}
      <div className="mb-6">
        <div className="flex justify-between items-center mb-2">
          <span className="text-sm font-medium text-gray-600">Progress Produksi</span>
          <span className="text-sm font-bold text-[#1e3a6e]">{progressPercentage}%</span>
        </div>
        <div className="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
          <div
            className="h-3 rounded-full bg-gradient-to-r from-[#1e3a6e] to-[#2e5090] transition-all duration-1000"
            style={{ width: `${progressPercentage}%` }}
          />
        </div>
      </div>

      {/* Timeline list */}
      <div className="space-y-1">
        {timeline.map((item, index) => (
          <div
            key={item.stage}
            className={`relative flex gap-4 pb-4 ${
              index !== timeline.length - 1 ? 'before:absolute before:left-[15px] before:top-[34px] before:w-[2px] before:h-[calc(100%-10px)] before:content-[""]' : ''
            } ${
              item.status === 'done' ? 'before:bg-green-400' : 'before:bg-gray-200'
            }`}
          >
            {/* Icon circle */}
            <div className="flex-shrink-0 relative z-10">
              {item.status === 'done' ? (
                <div className="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center shadow-sm">
                  <svg className="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2.5} d="M5 13l4 4L19 7" />
                  </svg>
                </div>
              ) : item.status === 'current' ? (
                <div className="w-8 h-8 rounded-full bg-[#1e3a6e] flex items-center justify-center shadow-md">
                  <svg viewBox="0 0 24 24" className="w-4 h-4 text-white" fill="none" stroke="currentColor" strokeWidth="1.5">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                  </svg>
                </div>
              ) : (
                <div className="w-8 h-8 rounded-full bg-gray-100 border-2 border-gray-200 flex items-center justify-center">
                  <div className="w-2 h-2 rounded-full bg-gray-300" />
                </div>
              )}
            </div>

            {/* Content */}
            <div className={`flex-1 min-w-0 pt-1 ${item.status === 'pending' ? 'opacity-40' : ''}`}>
              <div className="flex items-center justify-between gap-2 flex-wrap">
                <div className="flex items-center gap-2">
                  <span className={`text-sm font-semibold ${
                    item.status === 'done' ? 'text-gray-800' :
                    item.status === 'current' ? 'text-[#1e3a6e]' :
                    'text-gray-400'
                  }`}>
                    {item.label}
                  </span>
                  {item.status === 'current' && (
                    <span className="text-[10px] bg-[#1e3a6e] text-white px-2 py-0.5 rounded-full font-medium">
                      Sedang Dikerjakan
                    </span>
                  )}
                </div>
                {item.date && (
                  <span className="text-xs text-gray-400 flex-shrink-0">{item.date}</span>
                )}
              </div>

              {item.note && (
                <p className="text-xs text-gray-500 mt-0.5">{item.note}</p>
              )}

              {/* Photo - click opens full size */}
              {item.photo_url && (
                <div style={{ marginTop: '12px' }}>
                  <div 
                    onClick={() => setLightboxUrl(item.photo_url as string)}
                    style={{ display: 'inline-block', position: 'relative' }}
                    className="group"
                  >
                    <img
                      src={item.photo_url}
                      alt="Foto progres produksi"
                      style={{
                        display: 'block',
                        width: '200px',
                        height: '140px',
                        objectFit: 'cover',
                        borderRadius: '12px',
                        border: '1px solid #e5e7eb',
                        cursor: 'pointer',
                        boxShadow: '0 1px 3px rgba(0,0,0,0.1)',
                      }}
                      className="group-hover:opacity-90 transition-opacity duration-300"
                    />
                    <div className="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 rounded-xl flex items-center justify-center cursor-pointer pointer-events-none">
                       <div className="opacity-0 group-hover:opacity-100 transition-opacity bg-white rounded-full p-2 shadow-sm">
                           <svg className="w-5 h-5 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                       </div>
                    </div>
                  </div>
                  <p style={{ fontSize: '10px', color: '#9ca3af', marginTop: '4px' }}>
                    Klik foto untuk perbesar
                  </p>
                </div>
              )}
            </div>
          </div>
        ))}
      </div>

      {/* Lightbox Modal */}
      {lightboxUrl && (
        <div 
          className="fixed inset-0 z-[100] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
          onClick={() => setLightboxUrl(null)}
        >
          <div 
            className="relative max-w-4xl w-full"
            onClick={e => e.stopPropagation()}
          >
            <button 
              onClick={() => setLightboxUrl(null)}
              className="absolute -top-12 right-0 text-white/80 hover:text-white transition-colors bg-black/50 hover:bg-black/70 rounded-full p-2"
            >
              <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
            <img 
              src={lightboxUrl} 
              alt="Foto Progres Full" 
              className="w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl"
            />
            <div className="mt-4 text-center">
              <a 
                href={lightboxUrl} 
                target="_blank" 
                rel="noopener noreferrer"
                onClick={e => e.stopPropagation()}
                className="inline-flex items-center gap-2 text-white/70 hover:text-white text-sm transition-colors px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg"
              >
                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Buka di tab baru
              </a>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
