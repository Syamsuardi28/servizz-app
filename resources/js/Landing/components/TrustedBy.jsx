import React from 'react';
import { motion } from 'framer-motion';

const TrustedBy = () => {
    // Array of dummy partner names to render simple text logos
    const partners = ['Acme Corp', 'GlobalTech', 'Nexus', 'Innovate', 'Stark Ind.', 'Wayne Ent.'];

    return (
        <section className="py-12 border-y border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-white/[0.02]">
            <div className="container mx-auto px-6 max-w-7xl">
                <p className="text-center text-sm font-semibold text-gray-500 dark:text-gray-400 mb-8 uppercase tracking-wider">
                    Dipercaya oleh perusahaan inovatif
                </p>
                <div className="flex flex-wrap justify-center items-center gap-8 md:gap-16">
                    {partners.map((partner, index) => (
                        <motion.div
                            key={index}
                            initial={{ opacity: 0, y: 10 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ duration: 0.5, delay: index * 0.1 }}
                            className="text-2xl font-bold text-gray-400 dark:text-gray-600 transition-all duration-300 hover:text-gray-900 dark:hover:text-white cursor-default"
                        >
                            {partner}
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default TrustedBy;
