import React from 'react';
import { motion } from 'framer-motion';
import { ArrowRight } from 'lucide-react';

const CTA = ({ loginUrl, registerUrl }) => {
    return (
        <section className="py-24 relative overflow-hidden">
            <div className="container mx-auto px-6 max-w-5xl relative z-10">
                <motion.div 
                    initial={{ opacity: 0, y: 30 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.8 }}
                    className="bg-gray-900 dark:bg-[#161615] rounded-[2.5rem] p-10 md:p-20 text-center relative overflow-hidden shadow-2xl"
                >
                    {/* Animated gradient background */}
                    <div className="absolute inset-0 bg-gradient-to-r from-gray-900 via-[#1a0500] to-gray-900 dark:from-[#111] dark:via-[#220700] dark:to-[#111]"></div>
                    <div className="absolute -top-1/2 -right-1/4 w-[800px] h-[800px] bg-gradient-to-br from-[#F53003]/30 to-amber-500/10 blur-[100px] rounded-full animate-pulse opacity-50 mix-blend-screen pointer-events-none"></div>
                    
                    <div className="relative z-10">
                        <h2 className="text-4xl md:text-6xl font-bold text-white mb-6 leading-tight">
                            Siap untuk <br className="hidden md:block"/> Pengalaman Baru?
                        </h2>
                        <p className="text-xl text-gray-400 mb-10 max-w-2xl mx-auto">
                            Bergabung sekarang dengan ribuan teknisi dan pelanggan lainnya yang telah merasakan kemudahan Servizz.
                        </p>
                        
                        <div className="flex flex-col sm:flex-row justify-center gap-4">
                            {registerUrl && (
                                <a 
                                    href={registerUrl} 
                                    className="inline-flex justify-center items-center gap-2 px-8 py-4 rounded-full bg-[#F53003] text-white font-semibold hover:bg-[#e02a02] transition-all hover:-translate-y-1 shadow-xl shadow-[#F53003]/30"
                                >
                                    Daftar Sekarang
                                </a>
                            )}
                            <a 
                                href={loginUrl} 
                                className="inline-flex justify-center items-center gap-2 px-8 py-4 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white font-semibold hover:bg-white/20 transition-all hover:-translate-y-1"
                            >
                                Masuk ke Akun
                                <ArrowRight className="w-5 h-5" />
                            </a>
                        </div>
                    </div>
                </motion.div>
            </div>
        </section>
    );
};

export default CTA;
