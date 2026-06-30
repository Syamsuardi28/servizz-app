import React from 'react';
import { motion } from 'framer-motion';

const DashboardPreview = () => {
    return (
        <section className="py-24 bg-gray-50 dark:bg-white/[0.02] overflow-hidden">
            <div className="container mx-auto px-6 max-w-7xl">
                <div className="text-center max-w-3xl mx-auto mb-16">
                    <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        Dashboard Cerdas & Intuitif
                    </h2>
                    <p className="text-lg text-gray-600 dark:text-gray-400">
                        Kelola seluruh aktivitas Anda melalui satu pintu. Desain modern, bersih, dan mudah digunakan oleh siapapun.
                    </p>
                </div>

                <motion.div
                    initial={{ opacity: 0, y: 40 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.8 }}
                    className="relative max-w-5xl mx-auto"
                >
                    {/* Background glows */}
                    <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-[300px] bg-gradient-to-r from-[#F53003]/20 to-amber-500/20 blur-[100px] -z-10 rounded-full"></div>

                    {/* Browser Frame Large */}
                    <div className="bg-white dark:bg-[#161615] rounded-2xl shadow-2xl shadow-gray-200/50 dark:shadow-black/50 border border-gray-200 dark:border-white/10 overflow-hidden transform hover:-translate-y-2 transition-transform duration-500">
                        {/* Browser Header */}
                        <div className="h-12 border-b border-gray-100 dark:border-white/10 flex items-center px-4 justify-between bg-gray-50/50 dark:bg-white/5">
                            <div className="flex gap-2">
                                <div className="w-3 h-3 rounded-full bg-red-400"></div>
                                <div className="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div className="w-3 h-3 rounded-full bg-green-400"></div>
                            </div>
                            <div className="flex-1 max-w-md mx-4 h-6 rounded-md bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 hidden sm:block"></div>
                        </div>
                        
                        {/* Dashboard App Area (Mockup) */}
                        <div className="flex h-[400px] sm:h-[500px]">
                            {/* Sidebar */}
                            <div className="w-64 border-r border-gray-100 dark:border-white/10 p-6 hidden md:flex flex-col gap-6">
                                <div className="h-8 w-32 bg-gray-200 dark:bg-white/10 rounded"></div>
                                <div className="space-y-4 flex-1">
                                    {[1, 2, 3, 4, 5].map(i => (
                                        <div key={i} className="flex gap-3 items-center">
                                            <div className="w-5 h-5 rounded bg-gray-200 dark:bg-white/10"></div>
                                            <div className="h-3 w-24 bg-gray-100 dark:bg-white/5 rounded"></div>
                                        </div>
                                    ))}
                                </div>
                                <div className="h-10 w-full bg-gray-100 dark:bg-white/5 rounded-lg"></div>
                            </div>

                            {/* Main Content */}
                            <div className="flex-1 p-6 sm:p-8 bg-gray-50 dark:bg-[#111111] overflow-hidden">
                                {/* Header */}
                                <div className="flex justify-between items-center mb-8">
                                    <div className="space-y-2">
                                        <div className="h-6 w-40 bg-gray-200 dark:bg-white/10 rounded"></div>
                                        <div className="h-3 w-64 bg-gray-100 dark:bg-white/5 rounded"></div>
                                    </div>
                                    <div className="w-10 h-10 rounded-full bg-gray-200 dark:bg-white/10"></div>
                                </div>

                                {/* Stats Grid */}
                                <div className="grid grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mb-8">
                                    {[1, 2, 3].map((i) => (
                                        <div key={i} className="h-28 rounded-xl bg-white dark:bg-white/5 shadow-sm border border-gray-100 dark:border-white/5 p-4 flex flex-col justify-between">
                                            <div className="w-8 h-8 rounded-full bg-gray-100 dark:bg-white/10"></div>
                                            <div className="space-y-2">
                                                <div className="h-5 w-16 bg-gray-800 dark:bg-white/20 rounded"></div>
                                                <div className="h-3 w-20 bg-gray-300 dark:bg-white/10 rounded"></div>
                                            </div>
                                        </div>
                                    ))}
                                </div>

                                {/* Table Area */}
                                <div className="h-48 rounded-xl bg-white dark:bg-white/5 shadow-sm border border-gray-100 dark:border-white/5 p-6 space-y-4">
                                    <div className="h-4 w-32 bg-gray-200 dark:bg-white/10 rounded mb-4"></div>
                                    {[1, 2, 3].map((i) => (
                                        <div key={i} className="flex justify-between items-center pb-4 border-b border-gray-50 dark:border-white/5 last:border-0 last:pb-0">
                                            <div className="flex gap-4 items-center">
                                                <div className="w-8 h-8 rounded-full bg-gray-100 dark:bg-white/10"></div>
                                                <div className="space-y-2">
                                                    <div className="h-3 w-32 bg-gray-200 dark:bg-white/10 rounded"></div>
                                                    <div className="h-2 w-24 bg-gray-100 dark:bg-white/5 rounded"></div>
                                                </div>
                                            </div>
                                            <div className="h-6 w-20 bg-gray-100 dark:bg-white/5 rounded-full"></div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>
                </motion.div>
            </div>
        </section>
    );
};

export default DashboardPreview;
