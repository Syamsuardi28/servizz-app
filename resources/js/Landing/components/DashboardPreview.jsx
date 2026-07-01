import React from 'react';
import { motion } from 'framer-motion';
import { TrendingUp, TrendingDown, Users, Wrench, CheckCircle, Clock, Bell } from 'lucide-react';

const DashboardPreview = () => {
    const sidebarItems = [
        { icon: '🏠', label: 'Dashboard', active: true },
        { icon: '📋', label: 'Pesanan' },
        { icon: '👤', label: 'Profil' },
        { icon: '💬', label: 'Pesan' },
        { icon: '⚙️', label: 'Pengaturan' },
    ];

    const statusBadges = [
        { label: 'Selesai', class: 'bg-emerald-100 dark:bg-emerald-500/15 text-emerald-700 dark:text-emerald-400' },
        { label: 'Proses', class: 'bg-blue-100 dark:bg-blue-500/15 text-blue-700 dark:text-blue-400' },
        { label: 'Menunggu', class: 'bg-amber-100 dark:bg-amber-500/15 text-amber-700 dark:text-amber-400' },
    ];

    return (
        <section className="py-28 relative overflow-hidden">
            {/* Background */}
            <div className="absolute inset-0 bg-gradient-to-b from-gray-50/80 via-gray-50/60 to-transparent dark:from-white/[0.02] dark:via-white/[0.015] dark:to-transparent" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* Header */}
                <div className="text-center max-w-3xl mx-auto mb-16">
                    <motion.div
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="mb-5"
                    >
                        <span className="section-label">Platform</span>
                    </motion.div>
                    <motion.h2
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.1 }}
                        className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-5 leading-[1.1]"
                    >
                        Dashboard{' '}
                        <span className="text-gradient-primary">Cerdas</span>{' '}
                        & Intuitif
                    </motion.h2>
                    <motion.p
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.2 }}
                        className="text-lg text-gray-500 dark:text-gray-400 leading-relaxed"
                    >
                        Kelola seluruh aktivitas Anda melalui satu pintu. Desain modern, bersih, dan mudah digunakan oleh siapapun.
                    </motion.p>
                </div>

                <motion.div
                    initial={{ opacity: 0, y: 50 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.9, ease: [0.25, 0.46, 0.45, 0.94] }}
                    className="relative max-w-5xl mx-auto"
                >
                    {/* Background glow */}
                    <div className="absolute -inset-8 bg-gradient-to-br from-[#F53003]/10 via-amber-400/8 to-violet-500/10 dark:from-[#F53003]/15 dark:via-amber-500/10 dark:to-violet-500/12 blur-[60px] rounded-[48px]" />

                    {/* Browser Frame */}
                    <div className="relative bg-white dark:bg-[#141413] rounded-[28px] shadow-[0_40px_100px_rgba(0,0,0,0.1)] dark:shadow-[0_40px_100px_rgba(0,0,0,0.7)] border border-gray-200/60 dark:border-white/[0.07] overflow-hidden hover:-translate-y-2 transition-transform duration-700">

                        {/* Browser chrome */}
                        <div className="h-12 border-b border-gray-100 dark:border-white/[0.06] flex items-center px-5 justify-between bg-gray-50/60 dark:bg-white/[0.02]">
                            <div className="flex gap-2">
                                <div className="w-3 h-3 rounded-full bg-[#FF5F57]" />
                                <div className="w-3 h-3 rounded-full bg-[#FFBD2E]" />
                                <div className="w-3 h-3 rounded-full bg-[#28CA41]" />
                            </div>
                            {/* URL bar */}
                            <div className="flex-1 max-w-sm mx-6 h-7 rounded-lg bg-white dark:bg-white/5 border border-gray-200/80 dark:border-white/8 flex items-center gap-2 px-3">
                                <div className="w-3 h-3 rounded-full bg-emerald-400/80 flex-shrink-0" />
                                <div className="h-2 flex-1 bg-gray-200 dark:bg-white/10 rounded" />
                            </div>
                            {/* Right icons */}
                            <div className="flex items-center gap-2">
                                <div className="w-7 h-7 rounded-full bg-gray-100 dark:bg-white/5" />
                                <div className="relative w-7 h-7 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center">
                                    <div className="w-3 h-3 bg-gray-300 dark:bg-white/20 rounded-sm" />
                                    <div className="absolute -top-0.5 -right-0.5 w-2 h-2 rounded-full bg-[#F53003]" />
                                </div>
                            </div>
                        </div>

                        {/* App content */}
                        <div className="flex h-[440px] sm:h-[520px]">
                            {/* Sidebar */}
                            <div className="w-56 border-r border-gray-100 dark:border-white/[0.06] p-5 hidden md:flex flex-col gap-5 bg-white dark:bg-[#0f0f0e]">
                                {/* Logo in sidebar */}
                                <div className="flex items-center gap-2.5 mb-2">
                                    <div className="w-7 h-7 rounded-lg bg-gradient-to-br from-[#F53003] to-[#c52400] flex items-center justify-center text-white text-xs font-black">S</div>
                                    <div className="h-3 w-16 bg-gray-200 dark:bg-white/10 rounded" />
                                </div>
                                {/* Nav items */}
                                <div className="space-y-1 flex-1">
                                    {sidebarItems.map((item, i) => (
                                        <div key={i} className={`flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium transition-colors ${
                                            item.active
                                                ? 'bg-gradient-to-r from-[#F53003]/10 to-orange-400/5 dark:from-[#F53003]/15 dark:to-orange-500/5 text-[#F53003] dark:text-orange-400 border border-[#F53003]/15 dark:border-[#F53003]/20'
                                                : 'text-gray-400 dark:text-white/30 hover:bg-gray-50 dark:hover:bg-white/3'
                                        }`}>
                                            <span className="text-sm">{item.icon}</span>
                                            <div className="h-2 flex-1 bg-current opacity-30 rounded" />
                                        </div>
                                    ))}
                                </div>
                                {/* User avatar */}
                                <div className="flex items-center gap-2.5 p-3 rounded-xl bg-gray-50 dark:bg-white/[0.03] border border-gray-100 dark:border-white/[0.05]">
                                    <div className="w-8 h-8 rounded-full bg-gradient-to-br from-[#F53003] to-amber-400 flex-shrink-0" />
                                    <div className="space-y-1 flex-1">
                                        <div className="h-2 w-20 bg-gray-300 dark:bg-white/15 rounded" />
                                        <div className="h-1.5 w-14 bg-gray-200 dark:bg-white/8 rounded" />
                                    </div>
                                </div>
                            </div>

                            {/* Main content area */}
                            <div className="flex-1 p-6 sm:p-7 bg-gray-50/60 dark:bg-[#111110] overflow-hidden">
                                {/* Top bar */}
                                <div className="flex justify-between items-center mb-7">
                                    <div className="space-y-1.5">
                                        <div className="h-5 w-44 bg-gray-800 dark:bg-white/20 rounded font-bold" />
                                        <div className="h-2.5 w-56 bg-gray-200 dark:bg-white/8 rounded" />
                                    </div>
                                    <div className="flex items-center gap-2">
                                        <div className="h-8 w-24 bg-white dark:bg-white/5 rounded-xl border border-gray-200/80 dark:border-white/8" />
                                        <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-[#F53003] to-orange-400 shadow-lg shadow-[#F53003]/30 flex items-center justify-center">
                                            <div className="w-3 h-3 bg-white/60 rounded-sm" />
                                        </div>
                                    </div>
                                </div>

                                {/* Stats row */}
                                <div className="grid grid-cols-3 gap-3 sm:gap-4 mb-6">
                                    {[
                                        { color: 'from-blue-500 to-cyan-400', trend: <TrendingUp className="w-3 h-3" />, trendColor: 'text-emerald-500' },
                                        { color: 'from-[#F53003] to-orange-400', trend: <TrendingUp className="w-3 h-3" />, trendColor: 'text-emerald-500' },
                                        { color: 'from-violet-500 to-purple-400', trend: <TrendingDown className="w-3 h-3" />, trendColor: 'text-red-400' },
                                    ].map((s, i) => (
                                        <div key={i} className="rounded-2xl bg-white dark:bg-white/[0.04] border border-gray-100 dark:border-white/[0.06] p-4 flex flex-col justify-between shadow-sm">
                                            <div className={`w-8 h-8 rounded-xl bg-gradient-to-br ${s.color} shadow-lg mb-3`} />
                                            <div className="space-y-1.5">
                                                <div className="h-4 w-16 bg-gray-800 dark:bg-white/25 rounded font-bold" />
                                                <div className={`flex items-center gap-1 ${s.trendColor}`}>
                                                    {s.trend}
                                                    <div className="h-1.5 w-10 bg-current opacity-40 rounded" />
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>

                                {/* Table area */}
                                <div className="rounded-2xl bg-white dark:bg-white/[0.04] border border-gray-100 dark:border-white/[0.06] overflow-hidden shadow-sm">
                                    {/* Table header */}
                                    <div className="flex items-center justify-between px-5 py-3.5 border-b border-gray-50 dark:border-white/[0.04]">
                                        <div className="h-3 w-28 bg-gray-700 dark:bg-white/20 rounded" />
                                        <div className="h-6 w-16 bg-[#F53003]/10 dark:bg-[#F53003]/15 rounded-lg" />
                                    </div>
                                    {/* Table rows */}
                                    <div className="divide-y divide-gray-50 dark:divide-white/[0.04]">
                                        {statusBadges.map((item, i) => (
                                            <div key={i} className="flex justify-between items-center px-5 py-3.5">
                                                <div className="flex gap-3 items-center">
                                                    <div className="w-8 h-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-white/10 dark:to-white/5 flex-shrink-0" />
                                                    <div className="space-y-1.5">
                                                        <div className="h-2.5 w-28 bg-gray-200 dark:bg-white/15 rounded" />
                                                        <div className="h-1.5 w-20 bg-gray-100 dark:bg-white/8 rounded" />
                                                    </div>
                                                </div>
                                                <span className={`text-[10px] font-semibold px-2.5 py-1 rounded-full ${item.class}`}>
                                                    {item.label}
                                                </span>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Floating label badge */}
                    <motion.div
                        initial={{ opacity: 0, scale: 0.8 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.6 }}
className="absolute -bottom-5 left-1/2 -translate-x-1/2 bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] rounded-2xl px-5 py-3 shadow-xl flex items-center gap-3"
                    >
                        <div className="flex -space-x-2">
                            {['from-blue-500 to-cyan-400', 'from-[#F53003] to-amber-400', 'from-violet-500 to-purple-400'].map((g, i) => (
                                <div key={i} className={`w-7 h-7 rounded-full bg-gradient-to-br ${g} border-2 border-white dark:border-[#141413]`} />
                            ))}
                        </div>
                        <span className="text-sm font-semibold text-gray-900 dark:text-white">10,000+ pengguna aktif</span>
                        <div className="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" />
                    </motion.div>
                </motion.div>
            </div>
        </section>
    );
};

export default DashboardPreview;
