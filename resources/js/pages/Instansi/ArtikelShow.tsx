import InstansiLayout from '@/layouts/dashboardLayoutInstansi';
import { Head } from '@inertiajs/react';

type Article = {
    id: number;
    title: string;
    category: string | null;
    image: string | null;
    body: string;
    published_at: string | null;
};

interface Props {
    article: Article;
}

export default function ArtikelShow({ article }: Props) {
    return (
        <InstansiLayout>
            <Head title={article.title} />

            <article className="mx-auto max-w-3xl rounded-[2.5rem] bg-white p-8 shadow-sm">
                {article.category && (
                    <span className="mb-3 inline-block rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                        {article.category}
                    </span>
                )}
                <h1 className="mb-4 text-3xl font-bold text-gray-900">
                    {article.title}
                </h1>
                {article.published_at && (
                    <p className="mb-6 text-xs text-gray-400">
                        Dipublikasikan:{' '}
                        {new Date(article.published_at).toLocaleDateString(
                            'id-ID',
                        )}
                    </p>
                )}
                {article.image && (
                    <img
                        src={`/storage/${article.image}`}
                        alt={article.title}
                        className="mb-6 h-64 w-full rounded-3xl object-cover"
                    />
                )}
                <div className="prose max-w-none">
                    {article.body}
                </div>
            </article>
        </InstansiLayout>
    );
}
