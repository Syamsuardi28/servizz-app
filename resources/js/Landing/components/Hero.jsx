import React from 'react';
import { motion } from 'framer-motion';
import { ArrowRight, CheckCircle2, PlayCircle, Mail } from 'lucide-react';

const Hero = ({ loginUrl, registerUrl }) => {
    return (
        <section className="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
            {/* Background elements */}
            <div className="absolute top-0 inset-x-0 h-screen bg-gradient-to-b from-orange-50/50 to-white dark:from-[#1D0002]/40 dark:to-[#0a0a0a] -z-10" />
            
            {/* Animated blur blobs */}
            <motion.div 
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ duration: 2 }}
                className="absolute top-20 -left-64 w-[500px] h-[500px] bg-[#F53003]/20 dark:bg-[#F53003]/10 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-lighten -z-10" 
            />
            <motion.div 
                initial={{ opacity: 0 }}
                animate={{ opacity: 1 }}
                transition={{ duration: 2, delay: 0.5 }}
                className="absolute top-40 -right-64 w-[600px] h-[600px] bg-amber-400/20 dark:bg-amber-500/10 rounded-full blur-[120px] mix-blend-multiply dark:mix-blend-lighten -z-10" 
            />

            <div className="container mx-auto px-6 max-w-7xl">
                <div className="grid lg:grid-cols-2 gap-16 lg:gap-8 items-center">
                    
                    {/* Text Content */}
                    <div className="max-w-2xl">
                        <motion.div
                            initial={{ opacity: 0, y: 20 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.5 }}
                        >
                            <span className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 dark:bg-orange-500/20 text-[#F53003] dark:text-orange-400 text-sm font-semibold mb-6">
                                <span className="w-2 h-2 rounded-full bg-[#F53003] animate-pulse"></span>
                                Platform Jasa Profesional Terintegrasi
                            </span>
                            
                            <h1 className="text-5xl lg:text-7xl font-bold tracking-tight text-gray-900 dark:text-white mb-6 leading-[1.1]">
                                Solusi Jasa <span className="text-transparent bg-clip-text bg-gradient-to-r from-[#F53003] to-amber-500">Aman</span> & Terpantau.
                            </h1>
                            
                            <p className="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed max-w-lg">
                                Temukan teknisi handal, pantau progres secara real-time, dan tetap terhubung melalui notifikasi email otomatis.
                            </p>
                            
                            <div className="flex flex-col sm:flex-row gap-4 mb-10">
                                <a 
                                    href={registerUrl} 
                                    className="inline-flex justify-center items-center gap-2 px-8 py-4 rounded-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-semibold hover:bg-gray-800 dark:hover:bg-gray-100 transition-all hover:scale-105 shadow-xl shadow-gray-900/20 dark:shadow-white/10"
                                >
                                    Mulai Sekarang
                                    <ArrowRight className="w-5 h-5" />
                                </a>
                                <a 
                                    href={loginUrl} 
                                    className="inline-flex justify-center items-center gap-2 px-8 py-4 rounded-full bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-white font-semibold hover:bg-gray-50 dark:hover:bg-white/10 transition-all"
                                >
                                    Masuk Akun
                                </a>
                            </div>

                            <div className="flex items-center gap-6 text-sm text-gray-500 dark:text-gray-400 font-medium">
                                <div className="flex items-center gap-2">
                                    <CheckCircle2 className="w-5 h-5 text-green-500" />
                                    <span>Social Login Google</span>
                                </div>
                                <div className="flex items-center gap-2">
                                    <CheckCircle2 className="w-5 h-5 text-green-500" />
                                    <span>Dukungan Admin 24/7</span>
                                </div>
                            </div>
                        </motion.div>
                    </div>

                    {/* Dashboard Mockup */}
                    <motion.div
                        initial={{ opacity: 0, x: 50 }}
                        animate={{ opacity: 1, x: 0 }}
                        transition={{ duration: 0.8, delay: 0.2 }}
                        className="relative lg:h-[600px] flex items-center justify-center lg:justify-end"
                    >
                        {/* Browser Frame */}
                        <div className="relative w-full max-w-2xl bg-white dark:bg-[#161615] rounded-2xl shadow-2xl dark:shadow-black/50 border border-gray-200 dark:border-[#3E3E3A] overflow-hidden transform lg:rotate-[-2deg] hover:rotate-0 transition-transform duration-500">
                            {/* Browser Header */}
                            <div className="h-10 border-b border-gray-100 dark:border-[#3E3E3A] flex items-center px-4 gap-2 bg-gray-50/50 dark:bg-[#20201f]">
                                <div className="w-3 h-3 rounded-full bg-red-400"></div>
                                <div className="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div className="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            
                            {/* Mockup content */}
                            <div className="p-4 sm:p-6 bg-gray-50 dark:bg-[#0f0f0f]">
                                {/* Dummy Timeline Dashboard */}
                                <div className="flex gap-4 mb-6">
                                    <div className="w-1/3 h-32 rounded-xl bg-white dark:bg-[#1f1f1e] shadow-sm border border-gray-100 dark:border-[#3E3E3A] p-4 flex flex-col justify-between">
                                        <div className="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-500/20 flex items-center justify-center text-[#F53003]">
                                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div className="space-y-2">
                                            <div className="h-3 w-16 bg-gray-200 dark:bg-[#3E3E3A] rounded"></div>
                                            <div className="h-4 w-24 bg-gray-300 dark:bg-[#52524f] rounded"></div>
                                        </div>
                                    </div>
                                    <div className="flex-1 h-32 rounded-xl bg-[#F53003] shadow-lg p-6 flex flex-col justify-between text-white relative overflow-hidden">
                                        <div className="absolute right-[-20px] top-[-20px] w-32 h-32 bg-white/10 rounded-full blur-xl"></div>
                                        <div className="h-4 w-32 bg-white/30 rounded"></div>
                                        <div className="h-8 w-48 bg-white/40 rounded mt-2"></div>
                                    </div>
                                </div>
                                
                                <div className="space-y-3">
                                    {/* Timeline Mockups */}
                                    {[1, 2, 3].map((i) => (
                                        <div key={i} className="h-16 w-full rounded-lg bg-white dark:bg-[#1f1f1e] shadow-sm border border-gray-100 dark:border-[#3E3E3A] flex items-center px-4 gap-4">
                                            <div className="w-10 h-10 rounded-full bg-gray-200 dark:bg-[#262625]"></div>
                                            <div className="flex-1 space-y-2">
                                                <div className="h-3 w-32 bg-gray-200 dark:bg-[#3E3E3A] rounded"></div>
                                                <div className="h-2 w-24 bg-gray-100 dark:bg-[#262625] rounded"></div>
                                            </div>
                                            {i === 1 && <div className="h-6 w-20 bg-green-100 dark:bg-green-500/20 rounded-full"></div>}
                                            {i !== 1 && <div className="h-6 w-20 bg-gray-100 dark:bg-[#3E3E3A] rounded-full"></div>}
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>

                        {/* Floating Element 1 - Timeline Progress */}
                        <motion.div 
                            animate={{ y: [0, -15, 0] }}
                            transition={{ repeat: Infinity, duration: 4, ease: "easeInOut" }}
                            className="absolute -bottom-6 -left-6 lg:bottom-10 lg:-left-12 bg-white dark:bg-[#1a1a1a] p-4 rounded-xl shadow-xl border border-gray-100 dark:border-[#3E3E3A] flex items-center gap-4"
                        >
                            <div className="w-12 h-12 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <CheckCircle2 className="w-6 h-6" />
                            </div>
                            <div>
                                <p className="text-sm font-bold text-gray-900 dark:text-white">Teknisi Berangkat</p>
                                <p className="text-xs text-gray-500 dark:text-gray-400">Update Progres Baru</p>
                            </div>
                        </motion.div>

                        {/* Floating Element 2 - Email Notification */}
                        <motion.div 
                            animate={{ y: [0, 15, 0] }}
                            transition={{ repeat: Infinity, duration: 5, ease: "easeInOut", delay: 1 }}
                            className="absolute -top-6 -right-6 lg:top-20 lg:-right-8 bg-white dark:bg-[#1a1a1a] p-4 rounded-xl shadow-xl border border-gray-100 dark:border-[#3E3E3A] flex items-center gap-4"
                        >
                            <div className="w-10 h-10 rounded-full bg-orange-100 dark:bg-orange-500/20 flex items-center justify-center text-[#F53003] dark:text-orange-400">
                                <Mail className="w-5 h-5" />
                            </div>
                            <div>
                                <p className="text-sm font-bold text-gray-900 dark:text-white">Notifikasi Email</p>
                                <p className="text-xs text-gray-500 dark:text-gray-400">Terkirim Otomatis</p>
                            </div>
                        </motion.div>
                    </motion.div>

                </div>
            </div>
        </section>
    );
};

export default Hero;
