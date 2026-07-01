import React, { useEffect, useRef } from 'react';
import anime from 'animejs';
import { ArrowRight, Sparkles } from 'lucide-react';

const CTA = ({ loginUrl, registerUrl }) => {
    const ctaRef = useRef(null);
    const blobRef = useRef(null);

    useEffect(() => {
        // Blob continuous animation
        anime({
            targets: blobRef.current,
            translateX: ['-10%', '10%'],
            translateY: ['-10%', '10%'],
            scale: [1, 1.1],
            direction: 'alternate',
            loop: true,
            duration: 8000,
            easing: 'easeInOutSine'
        });

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    anime({
                        targets: '.cta-reveal',
                        opacity: [0, 1],
                        translateY: [30, 0],
                        duration: 800,
                        delay: anime.stagger(150),
                        easing: 'easeOutExpo'
                    });

                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        if (ctaRef.current) {
            observer.observe(ctaRef.current);
        }

        return () => observer.disconnect();
    }, []);

    return (
        <section className="py-24 relative overflow-hidden bg-[#050505]">
            <div className="container mx-auto px-6 max-w-5xl relative z-10">
                <div
                    ref={ctaRef}
                    className="relative rounded-[2.5rem] overflow-hidden shadow-[0_40px_100px_rgba(0,0,0,0.6)]"
                >
                    {/* Layered backgrounds */}
                    <div className="absolute inset-0 bg-[#0a0a0a]" />
                    
                    {/* Animated primary glow blob */}
                    <div 
                        ref={blobRef}
                        className="absolute -top-1/2 -right-1/4 w-[800px] h-[800px] bg-gradient-to-br from-[#F53003]/30 to-amber-500/20 blur-[150px] rounded-full opacity-80" 
                    />
                    
                    {/* Secondary glow */}
                    <div className="absolute -bottom-1/2 -left-1/4 w-[600px] h-[600px] bg-gradient-to-tr from-blue-500/10 via-purple-500/10 to-transparent blur-[120px] rounded-full" />
                    
                    {/* Top shimmer line */}
                    <div className="absolute top-0 inset-x-0 h-[1px] bg-gradient-to-r from-transparent via-[#F53003]/80 to-transparent" />
                    {/* Bottom shimmer line */}
                    <div className="absolute bottom-0 inset-x-0 h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent" />

                    {/* Grid pattern overlay */}
                    <div className="absolute inset-0 opacity-[0.03]"
                        style={{
                            backgroundImage: 'linear-gradient(rgba(255,255,255,1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,1) 1px, transparent 1px)',
                            backgroundSize: '40px 40px'
                        }}
                    />

                    {/* Content */}
                    <div className="relative z-10 text-center py-20 px-8 md:px-20">
                        {/* Badge */}
                        <div className="cta-reveal opacity-0 mb-7 flex justify-center">
                            <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 backdrop-blur-sm border border-white/10 text-gray-300 text-xs font-semibold tracking-wider uppercase">
                                <Sparkles className="w-3.5 h-3.5 text-[#F53003]" />
                                Bergabung Sekarang — Gratis
                            </span>
                        </div>

                        <h2 className="cta-reveal opacity-0 text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-[1.05]">
                            Siap untuk{' '}
                            <br className="hidden md:block" />
                            <span className="text-gradient-primary">Pengalaman Baru?</span>
                        </h2>

                        <p className="cta-reveal opacity-0 text-lg md:text-xl text-gray-400 mb-12 max-w-2xl mx-auto leading-relaxed">
                            Bergabung sekarang dengan ribuan teknisi dan pelanggan lainnya yang telah merasakan kemudahan Servizz.
                        </p>

                        <div className="cta-reveal opacity-0 flex flex-col sm:flex-row justify-center gap-4">
                            {registerUrl && (
                                <a
                                    href={registerUrl}
                                    className="btn-primary inline-flex justify-center items-center gap-2.5 px-8 py-4 rounded-2xl text-white font-semibold text-base shadow-[0_0_20px_rgba(245,48,3,0.3)] hover:shadow-[0_0_30px_rgba(245,48,3,0.5)] transition-all duration-300 hover:-translate-y-1"
                                >
                                    Daftar Sekarang
                                    <ArrowRight className="w-5 h-5" />
                                </a>
                            )}
                            <a
                                href={loginUrl}
                                className="inline-flex justify-center items-center gap-2.5 px-8 py-4 rounded-2xl bg-white/5 backdrop-blur-md border border-white/10 text-white font-semibold text-base hover:bg-white/10 hover:border-white/20 transition-all duration-300 hover:-translate-y-1"
                            >
                                Masuk ke Akun
                                <ArrowRight className="w-5 h-5" />
                            </a>
                        </div>

                        {/* Social proof below buttons */}
                        <div className="cta-reveal opacity-0 flex items-center justify-center gap-3 mt-12">
                            <div className="flex -space-x-2">
                                {['from-blue-500 to-cyan-400', 'from-[#F53003] to-amber-400', 'from-violet-500 to-purple-400', 'from-emerald-500 to-teal-400'].map((g, i) => (
                                    <div key={i} className={`w-8 h-8 rounded-full bg-gradient-to-br ${g} border-2 border-[#0a0a0a] shadow-sm`} />
                                ))}
                            </div>
                            <span className="text-sm text-gray-400">
                                <span className="text-white font-semibold">10,000+</span> pengguna sudah bergabung
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default CTA;
