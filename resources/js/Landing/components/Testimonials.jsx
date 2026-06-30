import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Star, ChevronLeft, ChevronRight } from 'lucide-react';
import { cn } from '../utils';

const testimonials = [
    {
        id: 1,
        name: "Budi Santoso",
        role: "Pemilik Bisnis",
        content: "Servizz sangat membantu operasional bisnis saya. Saat AC kantor rusak, saya bisa mendapatkan teknisi dalam waktu kurang dari 30 menit. Kualitas kerjanya juga sangat profesional.",
        rating: 5,
        image: "BS"
    },
    {
        id: 2,
        name: "Siti Rahmawati",
        role: "Ibu Rumah Tangga",
        content: "Aplikasi yang sangat mudah digunakan. Saya tidak perlu pusing mencari tukang ledeng lagi. Sistem pembayarannya juga jelas dan transparan.",
        rating: 5,
        image: "SR"
    },
    {
        id: 3,
        name: "Andi Wijaya",
        role: "Manajer IT",
        content: "Platform yang sangat modern dan responsif. Pengalaman user interface-nya luar biasa, dan fitur tracking-nya membuat kita tahu kapan teknisi akan sampai.",
        rating: 5,
        image: "AW"
    }
];

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
        <section className="py-24 bg-gray-50 dark:bg-white/[0.02]">
            <div className="container mx-auto px-6 max-w-7xl">
                <div className="text-center max-w-3xl mx-auto mb-16">
                    <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        Apa Kata Mereka?
                    </h2>
                    <p className="text-lg text-gray-600 dark:text-gray-400">
                        Ribuan pengguna telah mempercayakan perbaikan dan layanan mereka kepada Servizz.
                    </p>
                </div>

                <div className="relative max-w-4xl mx-auto px-4 sm:px-12">
                    <div className="overflow-hidden relative h-[350px] sm:h-[250px]">
                        <AnimatePresence mode="wait">
                            <motion.div
                                key={currentIndex}
                                initial={{ opacity: 0, x: 50 }}
                                animate={{ opacity: 1, x: 0 }}
                                exit={{ opacity: 0, x: -50 }}
                                transition={{ duration: 0.4 }}
                                className="absolute inset-0 flex flex-col items-center text-center justify-center p-6 bg-white dark:bg-[#161615] rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-black/20 border border-gray-100 dark:border-white/5"
                            >
                                <div className="flex gap-1 mb-6">
                                    {[...Array(testimonials[currentIndex].rating)].map((_, i) => (
                                        <Star key={i} className="w-5 h-5 fill-amber-400 text-amber-400" />
                                    ))}
                                </div>
                                <p className="text-lg sm:text-xl text-gray-700 dark:text-gray-300 italic mb-8 max-w-2xl leading-relaxed">
                                    "{testimonials[currentIndex].content}"
                                </p>
                                <div className="flex items-center gap-4">
                                    <div className="w-12 h-12 rounded-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 flex items-center justify-center font-bold">
                                        {testimonials[currentIndex].image}
                                    </div>
                                    <div className="text-left">
                                        <h4 className="font-bold text-gray-900 dark:text-white">
                                            {testimonials[currentIndex].name}
                                        </h4>
                                        <p className="text-sm text-gray-500 dark:text-gray-400">
                                            {testimonials[currentIndex].role}
                                        </p>
                                    </div>
                                </div>
                            </motion.div>
                        </AnimatePresence>
                    </div>

                    {/* Navigation Buttons */}
                    <button 
                        onClick={handlePrev}
                        className="absolute left-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white dark:bg-[#2a2a28] shadow-md flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors z-10"
                    >
                        <ChevronLeft className="w-6 h-6" />
                    </button>
                    <button 
                        onClick={handleNext}
                        className="absolute right-0 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-white dark:bg-[#2a2a28] shadow-md flex items-center justify-center text-gray-600 dark:text-gray-300 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors z-10"
                    >
                        <ChevronRight className="w-6 h-6" />
                    </button>

                    {/* Dots indicator */}
                    <div className="flex justify-center gap-2 mt-8">
                        {testimonials.map((_, index) => (
                            <button
                                key={index}
                                onClick={() => {
                                    setIsAutoPlaying(false);
                                    setCurrentIndex(index);
                                }}
                                className={cn(
                                    "h-2 rounded-full transition-all duration-300",
                                    currentIndex === index 
                                        ? "w-8 bg-[#F53003]" 
                                        : "w-2 bg-gray-300 dark:bg-gray-600 hover:bg-gray-400"
                                )}
                            />
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Testimonials;
