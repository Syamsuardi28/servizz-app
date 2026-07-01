import React from 'react';
import { motion } from 'framer-motion';

const TrustedBy = () => {
    const partners = ['Acme Corp', 'GlobalTech', 'Nexus', 'Innovate', 'Stark Ind.', 'Wayne Ent.'];
    // Duplicate for seamless infinite loop
    const allPartners = [...partners, ...partners];

    return (
        <section className="py-14 relative overflow-hidden border-y border-gray-100/80 dark:border-white/[0.05]">
            {/* Subtle background */}
            <div className="absolute inset-0 bg-gradient-to-r from-white via-gray-50/80 to-white dark:from-[#0a0a0a] dark:via-[#0f0f0e] dark:to-[#0a0a0a]" />

            {/* Fade masks */}
            <div className="absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-white dark:from-[#0a0a0a] to-transparent z-10" />
            <div className="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white dark:from-[#0a0a0a] to-transparent z-10" />

            <div className="container mx-auto px-6 max-w-7xl mb-8 relative z-10">
                <motion.p
                    initial={{ opacity: 0, y: 8 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    className="text-center text-xs font-semibold text-gray-400 dark:text-gray-600 uppercase tracking-[0.2em] mb-8"
                >
                    Dipercaya oleh perusahaan inovatif
                </motion.p>
            </div>

            {/* Marquee track */}
            <div className="flex overflow-hidden">
                <div className="flex animate-marquee whitespace-nowrap">
                    {allPartners.map((partner, index) => (
                        <div
                            key={index}
                            className="inline-flex items-center mx-10 group cursor-default"
                        >
                            <span className="text-xl md:text-2xl font-black text-gray-200 dark:text-white/10 group-hover:text-gray-500 dark:group-hover:text-white/30 transition-all duration-500 tracking-tight select-none">
                                {partner}
                            </span>
                            {/* Separator dot */}
                            <span className="ml-10 w-1.5 h-1.5 rounded-full bg-gray-200 dark:bg-white/10 group-hover:bg-[#F53003]/40 transition-colors duration-500" />
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default TrustedBy;
