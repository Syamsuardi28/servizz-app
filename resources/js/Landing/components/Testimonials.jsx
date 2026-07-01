import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
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
];

const TestimonialCard = ({ testimonial, isActive }) => (
    <div className={cn(
        'bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] rounded-2xl p-7 flex flex-col gap-5 relative overflow-hidden transition-all duration-500',
        isActive
            ? 'shadow-[0_20px_60px_rgba(0,0,0,0.1)] dark:shadow-[0_20px_60px_rgba(0,0,0,0.4)] border-[#F53003]/20 dark:border-[#F53003]/25 scale-100'
            : 'opacity-70 dark:opacity-50 scale-[0.97]'
    )}>
        {/* Decorative quote mark */}
        <div className="absolute -top-2 -right-2 text-gray-100 dark:text-white/[0.04] select-none pointer-events-none">
            <Quote className="w-24 h-24" />
        </div>

        {/* Stars */}
        <div className="flex gap-1">
            {[...Array(testimonial.rating)].map((_, i) => (
                <motion.div
                    key={i}
                    initial={{ opacity: 0, scale: 0 }}
                    animate={{ opacity: 1, scale: 1 }}
                    transition={{ delay: i * 0.06 }}
                >
                    <Star className="w-4 h-4 fill-amber-400 text-amber-400" />
                </motion.div>
            ))}
        </div>

        {/* Content */}
        <p className="text-gray-600 dark:text-gray-300 leading-relaxed text-[15px] flex-1 relative z-10">
            "{testimonial.content}"
        </p>

        {/* Author */}
        <div className="flex items-center gap-3.5">
            <div className={`w-11 h-11 rounded-xl bg-gradient-to-br ${testimonial.gradient} flex items-center justify-center text-white font-bold text-sm shadow-lg flex-shrink-0`}>
                {testimonial.initials}
            </div>
            <div>
                <h4 className="font-bold text-gray-900 dark:text-white text-sm">{testimonial.name}</h4>
                <p className="text-xs text-gray-500 dark:text-gray-400">{testimonial.role}</p>
            </div>
        </div>
    </div>
);

const Testimonials = () => {
    const [currentIndex, setCurrentIndex] = useState(0);
    const [isAutoPlaying, setIsAutoPlaying] = useState(true);

    useEffect(() => {
        if (!isAutoPlaying) return;
        const timer = setInterval(() => {
            setCurrentIndex((prev) => (prev + 1) % testimonials.length);
        }, 5000);
        return () => clearInterval(timer);
    }, [isAutoPlaying]);

    const handleNext = () => {
        setIsAutoPlaying(false);
        setCurrentIndex((prev) => (prev + 1) % testimonials.length);
    };

    const handlePrev = () => {
        setIsAutoPlaying(false);
        setCurrentIndex((prev) => (prev - 1 + testimonials.length) % testimonials.length);
    };

    return (
        <section className="py-28 relative overflow-hidden">
            {/* Background */}
            <div className="absolute inset-0 bg-gradient-to-b from-transparent via-gray-50/60 to-transparent dark:via-white/[0.02]" />
            <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[300px] bg-[#F53003]/4 dark:bg-[#F53003]/6 blur-[100px] rounded-full" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* Header */}
                <div className="text-center max-w-3xl mx-auto mb-16">
                    <motion.div
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="mb-5"
                    >
                        <span className="section-label">Testimoni</span>
                    </motion.div>
                    <motion.h2
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.1 }}
                        className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-5 leading-[1.1]"
                    >
                        Apa Kata{' '}
                        <span className="text-gradient-primary">Mereka?</span>
                    </motion.h2>
                    <motion.p
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.2 }}
                        className="text-lg text-gray-500 dark:text-gray-400 leading-relaxed"
                    >
                        Ribuan pengguna telah mempercayakan perbaikan dan layanan mereka kepada Servizz.
                    </motion.p>
                </div>

                {/* Desktop: 3-column grid */}
                <div className="hidden lg:grid grid-cols-3 gap-6 mb-12">
                    {testimonials.map((testimonial, index) => (
                        <motion.div
                            key={testimonial.id}
                            initial={{ opacity: 0, y: 24 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ duration: 0.5, delay: index * 0.1 }}
                            whileHover={{ y: -5 }}
                        >
                            <TestimonialCard
                                testimonial={testimonial}
                                isActive={index === currentIndex}
                            />
                        </motion.div>
                    ))}
                </div>

                {/* Mobile: Carousel */}
                <div className="lg:hidden relative">
                    <div className="overflow-hidden">
                        <AnimatePresence mode="wait">
                            <motion.div
                                key={currentIndex}
                                initial={{ opacity: 0, x: 40 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -40 }}
                                transition={{ duration: 0.35 }}
                            >
                                <TestimonialCard
                                    testimonial={testimonials[currentIndex]}
                                    isActive={true}
                                />
                            </motion.div>
                        </AnimatePresence>
                    </div>

                    {/* Nav buttons */}
                    <div className="flex items-center justify-center gap-3 mt-6">
                        <button
                            onClick={handlePrev}
                            className="w-10 h-10 rounded-full bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-gray-200/60 dark:border-white/10 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-[#F53003] hover:border-[#F53003]/30 transition-all duration-200"
                        >
                            <ChevronLeft className="w-5 h-5" />
                        </button>
                        {testimonials.map((_, index) => (
                            <button
                                key={index}
                                onClick={() => { setIsAutoPlaying(false); setCurrentIndex(index); }}
                                className={cn(
                                    'h-2 rounded-full transition-all duration-300',
                                    currentIndex === index
                                        ? 'w-7 bg-[#F53003]'
                                        : 'w-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400'
                                )}
                            />
                        ))}
                        <button
                            onClick={handleNext}
                            className="w-10 h-10 rounded-full bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-gray-200/60 dark:border-white/10 flex items-center justify-center text-gray-500 dark:text-gray-400 hover:text-[#F53003] hover:border-[#F53003]/30 transition-all duration-200"
                        >
                            <ChevronRight className="w-5 h-5" />
                        </button>
                    </div>
                </div>

                {/* Desktop navigation dots */}
                <div className="hidden lg:flex items-center justify-center gap-2 mt-8">
                    {testimonials.map((_, index) => (
                        <button
                            key={index}
                            onClick={() => { setIsAutoPlaying(false); setCurrentIndex(index); }}
                            className={cn(
                                'h-2 rounded-full transition-all duration-300',
                                currentIndex === index
                                    ? 'w-7 bg-[#F53003]'
                                    : 'w-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400'
                            )}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Testimonials;
