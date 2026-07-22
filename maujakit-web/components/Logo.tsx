import Image from 'next/image';
import Link from 'next/link';

interface LogoProps {
  variant?: 'dark' | 'light';
  size?: 'sm' | 'md' | 'lg';
  showText?: boolean;
  href?: string;
  className?: string;
}

const sizes = {
  sm: { img: 36, title: 'text-sm', sub: 'text-[9px]' },
  md: { img: 44, title: 'text-base', sub: 'text-[10px]' },
  lg: { img: 64, title: 'text-xl', sub: 'text-xs' },
};

export default function Logo({
  variant = 'dark',
  size = 'md',
  showText = true,
  href = '/',
  className = '',
}: LogoProps) {
  const s = sizes[size];
  const textColor = variant === 'light' ? 'text-white' : 'text-[#1e3a6e]';
  const subColor = variant === 'light' ? 'text-white/50' : 'text-gray-500';

  const content = (
    <div className={`flex items-center gap-2.5 ${className}`}>
      <Image
        src="/logo.png"
        alt="MauJahit.id Logo"
        width={s.img}
        height={s.img}
        className="rounded-xl flex-shrink-0 object-cover"
        priority
      />
      {showText && (
        <div>
          <div className={`font-black tracking-wide leading-tight ${s.title} ${textColor}`}>
            MAUJAHIT.ID
          </div>
          <div className={`font-medium tracking-widest uppercase ${s.sub} ${subColor}`}>
            Clothing Vendor
          </div>
        </div>
      )}
    </div>
  );

  if (href) {
    return (
      <Link href={href} className="hover:opacity-90 transition-opacity">
        {content}
      </Link>
    );
  }

  return content;
}
