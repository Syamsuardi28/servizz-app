import React from 'react';
import { motion } from 'framer-motion';
import { ArrowRight, Sparkles } from 'lucide-react';

const CTA = ({ loginUrl, registerUrl }) => {
    return (
        <section className="py-24 relative overflow-hidden">
            <div className="container mx-auto px-6 max-w-5xl relative z-10">
                <motion.div
                    initial={{ opacity: 0, y: 40, scale: 0.97 }}
                    whileInView={{ opacity: 1, y: 0, scale: 1 }}
                    viewport={{ once: true }}
                    transition={{ duration: 0.8, ease: [0.25, 0.46, 0.45, 0.94] }}
                    className="relative rounded-[2.5rem] overflow-hidden shadow-[0_40px_100px_rgba(0,0,0,0.25)] dark:shadow-[0_40px_100px_rgba(0,0,0,0.6)]"
                >
                    {/* Layered backgrounds */}
                    <div className="absolute inset-0 bg-gradient-to-br from-gray-950 via-[#180400] to-gray-950 dark:from-[#0a0a0a] dark:via-[#1a0300] dark:to-[#0a0a0a]" />
                    {/* Primary glow blob */}
                    <div className="absolute -top-1/2 -right-1/4 w-[700px] h-[700px] bg-gradient-to-br from-[#F53003]/40 to-amber-500/15 blur-[120px] rounded-full animate-pulse-glow opacity-60" />
                    {/* Secondary glow */}
                    <div className="absolute -bottom-1/2 -left-1/4 w-[500px] h-[500px] bg-gradient-to-tr from-[#F53003]/20 to-transparent blur-[100px] rounded-full" />
                    {/* Top shimmer line */}
                    <div className="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-[#F53003]/60 to-transparent" />
                    {/* Bottom shimmer line */}
                    <div className="absolute bottom-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent" />

                    {/* Grid pattern overlay */}
                    <div className="absolute inset-0 opacity-[0.04]"
                        style={{
                            backgroundImage: 'linear-gradient(rgba(255,255,255,1) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,1) 1px, transparent 1px)',
                            backgroundSize: '60px 60px'
                        }}
                    />

                    {/* Content */}
                    <div className="relative z-10 text-center py-20 px-8 md:px-20">
                        {/* Badge */}
                        <motion.div
                            initial={{ opacity: 0, y: 10 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            className="mb-7 flex justify-center"
                        >
                            <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/15 text-white/80 text-xs font-semibold tracking-wider uppercase">
                                <Sparkles className="w-3.5 h-3.5 text-amber-400" />
                                Bergabung Sekarang — Gratis
                            </span>
                        </motion.div>

                        <motion.h2
                            initial={{ opacity: 0, y: 20 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ delay: 0.1 }}
                            className="text-4xl md:text-6xl lg:text-7xl font-bold text-white mb-6 leading-[1.05]"
                        >
                            Siap untuk{' '}
                            <br className="hidden md:block" />
                            <span className="text-gradient-primary">Pengalaman Baru?</span>
                        </motion.h2>

                        <motion.p
                            initial={{ opacity: 0, y: 20 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ delay: 0.2 }}
                            className="text-lg md:text-xl text-gray-400 mb-12 max-w-2xl mx-auto leading-relaxed"
                        >
                            Bergabung sekarang dengan ribuan teknisi dan pelanggan lainnya yang telah merasakan kemudahan Servizz.
                        </motion.p>

                        <motion.div
                            initial={{ opacity: 0, y: 20 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ delay: 0.3 }}
                            className="flex flex-col sm:flex-row justify-center gap-4"
                        >
                            {registerUrl && (
                                <a
                                    href={registerUrl}
                                    className="btn-primary inline-flex justify-center items-center gap-2.5 px-8 py-4 rounded-2xl text-white font-semibold text-base"
                                >
                                    Daftar Sekarang
                                    <ArrowRight className="w-5 h-5" />
                                </a>
                            )}
                            <a
                                href={loginUrl}
                                className="inline-flex justify-center items-center gap-2.5 px-8 py-4 rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold text-base hover:bg-white/15 hover:border-white/30 transition-all duration-300 hover:-translate-y-0.5"
                            >
                                Masuk ke Akun
                                <ArrowRight className="w-5 h-5" />
                            </a>
                        </motion.div>

                        {/* Social proof below buttons */}
                        <motion.div
                            initial={{ opacity: 0 }}
                            whileInView={{ opacity: 1 }}
                            viewport={{ once: true }}
                            transition={{ delay: 0.5 }}
                            className="flex items-center justify-center gap-3 mt-10"
                        >
                            <div className="flex -space-x-2">
                                {['from-blue-500 to-cyan-400', 'from-[#F53003] to-amber-400', 'from-violet-500 to-purple-400', 'from-emerald-500 to-teal-400'].map((g, i) => (
                                    <div key={i} className={`w-8 h-8 rounded-full bg-gradient-to-br ${g} border-2 border-[#180400] dark:border-[#1a0300]`} />
                                ))}
                            </div>
                            <span className="text-sm text-gray-400">
                                <span className="text-white font-semibold">10,000+</span> pengguna sudah bergabung
                            </span>
                        </motion.div>
                    </div>
                </motion.div>
            </div>
        </section>
    );
};

export default CTA;
