import InstansiLayout from '@/layouts/dashboardLayoutInstansi';
import { Head, Link } from '@inertiajs/react';
import { HiArrowRight } from 'react-icons/hi';
import { route } from 'ziggy-js';


type Article = {
    id: number;
    title: string;
    slug: string;
    category: string | null;
    blurb: string | null;
    image: string | null;
    published_at: string | null;
};

interface Props {
    articles: Article[];
}

export default function Artikel({ articles }: Props) {
    return (
        <InstansiLayout>
            <Head title="Artikel & Update" />

            <h2 className="mb-8 text-3xl font-bold text-gray-900">
                Artikel & Update
            </h2>

            <div className="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                {articles.map((article) => (
                    <div
                        key={article.id}
                        className="group flex flex-col overflow-hidden rounded-[2rem] bg-white shadow-sm"
                    >
                        <img
                            src={
                                article.image
                                    ? `/storage/${article.image}`
                                    : 'https://via.placeholder.com/600x400.png?text=Artikel'
                            }
                            alt={article.title}
                            className="h-48 w-full object-cover"
                        />
                        <div className="flex flex-1 flex-col p-6">
                            {article.category && (
                                <span className="mb-3 inline-block w-fit rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                    {article.category}
                                </span>
                            )}
                            <h3 className="mb-2 flex-1 text-lg font-bold text-gray-900">
                                {article.title}
                            </h3>
                            {article.blurb && (
                                <p className="mb-4 text-sm text-gray-500">
                                    {article.blurb}
                                </p>
                            )}
                            <Link
                                href={route('artikel.show', article.slug)}
                                className="inline-flex items-center text-sm font-bold text-saintara-yellow transition-colors group-hover:gap-2 hover:text-yellow-500"
                            >
                                Baca Selengkapnya
                                <HiArrowRight className="ml-1 h-4 w-4" />
                            </Link>
                        </div>
                    </div>
                ))}
            </div>
        </InstansiLayout>
    );
}
