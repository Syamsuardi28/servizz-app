import React, { useState, useEffect, useRef } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import anime from 'animejs';
import { Star, ChevronLeft, ChevronRight, Quote } from 'lucide-react';
import { cn } from '../utils';

const testimonials = [
    {
        id: 1,
        name: 'Budi Santoso',
        role: 'Pemilik Bisnis',
        content: 'Servizz sangat membantu operasional bisnis saya. Saat AC kantor rusak, saya bisa mendapatkan teknisi dalam waktu kurang dari 30 menit. Kualitas kerjanya juga sangat profesional.',
        rating: 5,
        initials: 'BS',
        gradient: 'from-blue-500 to-cyan-400',
    },
    {
        id: 2,
        name: 'Siti Rahmawati',
        role: 'Ibu Rumah Tangga',
        content: 'Aplikasi yang sangat mudah digunakan. Saya tidak perlu pusing mencari tukang ledeng lagi. Sistem pembayarannya juga jelas dan transparan.',
        rating: 5,
        initials: 'SR',
        gradient: 'from-[#F53003] to-amber-400',
    },
    {
        id: 3,
        name: 'Andi Wijaya',
        role: 'Manajer IT',
        content: 'Platform yang sangat modern dan responsif. Pengalaman user interface-nya luar biasa, dan fitur tracking-nya membuat kita tahu kapan teknisi akan sampai.',
        rating: 5,
        initials: 'AW',
        gradient: 'from-violet-500 to-purple-400',
    },
    {
        id: 4,
        name: 'Dewi Lestari',
        role: 'Desainer Interior',
        content: 'Saya sering merekomendasikan Servizz ke klien saya untuk instalasi kelistrikan. Mereka selalu puas dengan kecepatan dan kerapihan kerjanya.',
        rating: 5,
        initials: 'DL',
        gradient: 'from-pink-500 to-rose-400',
    },
    {
        id: 5,
        name: 'Rudi Hermawan',
        role: 'Pengusaha Kuliner',
        content: 'Kulkas restoran sempat bermasalah, untung ada Servizz. Teknisi datang malam hari dan langsung selesai diperbaiki. Sangat recommended!',
        rating: 5,
        initials: 'RH',
        gradient: 'from-emerald-500 to-teal-400',
    }
];

const Testimonials = () => {
    const [currentIndex, setCurrentIndex] = useState(2); // Start at middle
    const [isAutoPlaying, setIsAutoPlaying] = useState(true);
    const sectionRef = useRef(null);

    useEffect(() => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    anime({
                        targets: '.testi-header',
                        opacity: [0, 1],
                        translateY: [20, 0],
                        duration: 800,
                        easing: 'easeOutExpo'
                    });
                    
                    anime({
                        targets: '.testi-carousel',
                        opacity: [0, 1],
                        scale: [0.95, 1],
                        duration: 1000,
                        delay: 300,
                        easing: 'easeOutExpo'
                    });

                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        if (sectionRef.current) {
            observer.observe(sectionRef.current);
        }

        return () => observer.disconnect();
    }, []);

    useEffect(() => {
        if (!isAutoPlaying) return;
        const timer = setInterval(() => {
            handleNext();
        }, 4000);
        return () => clearInterval(timer);
    }, [isAutoPlaying, currentIndex]);

    const handleNext = () => {
        setCurrentIndex((prev) => (prev + 1) % testimonials.length);
    };

    const handlePrev = () => {
        setCurrentIndex((prev) => (prev - 1 + testimonials.length) % testimonials.length);
    };

    // Calculate position relative to center
    const getPosition = (index) => {
        const diff = (index - currentIndex + testimonials.length) % testimonials.length;
        if (diff === 0) return 'center'; // Center
        if (diff === 1 || diff === - (testimonials.length - 1)) return 'right'; // Right
        if (diff === testimonials.length - 1 || diff === -1) return 'left'; // Left
        if (diff === 2) return 'far-right';
        return 'far-left';
    };

    const variants = {
        center: { x: '0%', scale: 1, zIndex: 30, opacity: 1, rotateY: 0 },
        left: { x: '-60%', scale: 0.8, zIndex: 20, opacity: 0.6, rotateY: 15 },
        right: { x: '60%', scale: 0.8, zIndex: 20, opacity: 0.6, rotateY: -15 },
        'far-left': { x: '-100%', scale: 0.6, zIndex: 10, opacity: 0, rotateY: 25 },
        'far-right': { x: '100%', scale: 0.6, zIndex: 10, opacity: 0, rotateY: -25 },
    };

    return (
        <section id="testimonials" ref={sectionRef} className="py-32 relative overflow-hidden bg-[#050505]">
            {/* Background */}
            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[400px] bg-blue-500/10 blur-[120px] rounded-full z-0 pointer-events-none" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* Header */}
                <div className="testi-header opacity-0 text-center max-w-3xl mx-auto mb-20">
                    <div className="mb-5">
                        <span className="section-label bg-white/5 border border-white/10 text-blue-500">Testimoni</span>
                    </div>
                    <h2 className="text-4xl md:text-5xl font-bold text-white mb-5 leading-[1.1]">
                        Apa Kata{' '}
                        <span className="text-gradient-primary">Mereka?</span>
                    </h2>
                    <p className="text-lg text-gray-400 leading-relaxed">
                        Ribuan pengguna telah mempercayakan perbaikan dan layanan mereka kepada Servizz.
                    </p>
                </div>

                {/* 3D Carousel */}
                <div className="testi-carousel opacity-0 relative h-[450px] w-full max-w-5xl mx-auto flex items-center justify-center perspective-1000">
                    {testimonials.map((testimonial, index) => {
                        const position = getPosition(index);
                        return (
                            <motion.div
                                key={testimonial.id}
                                className="absolute w-[90%] md:w-[450px]"
                                initial={false}
                                animate={position}
                                variants={variants}
                                transition={{ duration: 0.6, ease: [0.25, 0.46, 0.45, 0.94] }}
                                style={{ transformStyle: 'preserve-3d' }}
                                onClick={() => {
                                    setIsAutoPlaying(false);
                                    if (position === 'left') handlePrev();
                                    if (position === 'right') handleNext();
                                }}
                            >
                                <div className={cn(
                                    "bg-white/[0.03] backdrop-blur-xl border rounded-3xl p-8 flex flex-col gap-6 relative transition-colors duration-500",
                                    position === 'center' 
                                        ? "border-blue-500/30 shadow-[0_20px_60px_rgba(59,130,246,0.15)] bg-white/[0.06]" 
                                        : "border-white/[0.08] cursor-pointer hover:bg-white/[0.05]"
                                )}>
                                    {/* Quote Icon */}
                                    <div className="absolute -top-3 -right-3 text-white/[0.04]">
                                        <Quote className="w-32 h-32" />
                                    </div>

                                    {/* Stars */}
                                    <div className="flex gap-1">
                                        {[...Array(testimonial.rating)].map((_, i) => (
                                            <Star key={i} className="w-5 h-5 fill-amber-400 text-amber-400" />
                                        ))}
                                    </div>

                                    {/* Content */}
                                    <p className="text-gray-300 leading-relaxed text-lg relative z-10 min-h-[120px]">
                                        "{testimonial.content}"
                                    </p>

                                    {/* Author */}
                                    <div className="flex items-center gap-4 border-t border-white/10 pt-6">
                                        <div className={`w-12 h-12 rounded-xl bg-gradient-to-br ${testimonial.gradient} flex items-center justify-center text-white font-bold text-lg shadow-lg flex-shrink-0`}>
                                            {testimonial.initials}
                                        </div>
                                        <div>
                                            <h4 className="font-bold text-white text-base">{testimonial.name}</h4>
                                            <p className="text-sm text-gray-400">{testimonial.role}</p>
                                        </div>
                                    </div>
                                </div>
                            </motion.div>
                        );
                    })}
                </div>

                {/* Controls */}
                <div className="flex items-center justify-center gap-6 mt-8">
                    <button
                        onClick={() => { setIsAutoPlaying(false); handlePrev(); }}
                        className="w-12 h-12 rounded-full bg-white/[0.03] hover:bg-white/[0.08] border border-white/10 flex items-center justify-center text-white transition-all duration-200"
                    >
                        <ChevronLeft className="w-6 h-6" />
                    </button>
                    
                    <div className="flex gap-2">
                        {testimonials.map((_, index) => (
                            <button
                                key={index}
                                onClick={() => { setIsAutoPlaying(false); setCurrentIndex(index); }}
                                className={cn(
                                    'h-2 rounded-full transition-all duration-300',
                                    currentIndex === index
                                        ? 'w-8 bg-blue-500'
                                        : 'w-2 bg-white/20 hover:bg-white/40'
                                )}
                            />
                        ))}
                    </div>

                    <button
                        onClick={() => { setIsAutoPlaying(false); handleNext(); }}
                        className="w-12 h-12 rounded-full bg-white/[0.03] hover:bg-white/[0.08] border border-white/10 flex items-center justify-center text-white transition-all duration-200"
                    >
                        <ChevronRight className="w-6 h-6" />
                    </button>
                </div>
            </div>
        </section>
    );
};

export default Testimonials;
