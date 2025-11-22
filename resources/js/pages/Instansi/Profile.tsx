// resources/js/Pages/Instansi/Profile.tsx

import InstansiLayout from '@/layouts/dashboardLayoutInstansi'; // Menggunakan Layout Institusi
import { Head, useForm } from '@inertiajs/react';
import React from 'react';
import { route } from 'ziggy-js';

// --- TIPE DATA DARI BACKEND ---
type Instansi = {
    id_instansi: number;
    nama_instansi: string;
    email: string;
    no_telp: string | null;
    website: string | null;
    alamat_instansi: string | null;
    logo?: string | null; // opsional kalau sudah simpan logo di DB
};

interface ProfileProps {
    instansi: Instansi;
}

export default function Profile({ instansi }: ProfileProps) {
    // useForm Inertia: isi awal dari data instansi
    const { data, setData, post, processing, errors } = useForm({
        name: instansi?.nama_instansi ?? '',
        email: instansi?.email ?? '',
        phone: instansi?.no_telp ?? '',
        website: instansi?.website ?? '',
        address: instansi?.alamat_instansi ?? '',
        logo: null as File | null, // Untuk upload file
    });

    // Avatar: pakai logo dari DB kalau ada, kalau tidak pakai ui-avatars
    const avatarUrl = instansi?.logo
        ? `/storage/${instansi.logo}`
        : `https://ui-avatars.com/api/?name=${encodeURIComponent(
              data.name || 'Organisasi',
          )}&background=FACC15&color=000&size=128`;

    // Handler untuk input teks/textarea
    const handleChange = (
        e: React.ChangeEvent<
            HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement
        >,
    ) => {
        const { id, value } = e.target;
        setData(id as keyof typeof data, value);
    };

    // Handler untuk submit form → kirim ke backend
    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();

        // Sesuaikan dengan route di Laravel:
        // Route::post('/instansi/profilInstansi', ...)->name('instansi.profil.update');
        post(route('instansi.profil.update'));
    };

    return (
        <InstansiLayout>
            <Head title="Profil Organisasi" />

            <h2 className="mb-8 text-3xl font-bold text-gray-900">
                Profil Organisasi
            </h2>

            {/* Form utama dibungkus tag <form> */}
            <form onSubmit={handleSubmit} className="space-y-8">
                <div className="grid grid-cols-1 gap-8 lg:grid-cols-3">
                    {/* === KOLOM KIRI (Logo) === */}
                    <div className="lg:col-span-1">
                        <div className="sticky top-8 rounded-[2.5rem] bg-white p-8 text-center shadow-sm">
                            <img
                                src={avatarUrl}
                                alt="Logo Organisasi"
                                className="mx-auto mb-6 h-32 w-32 rounded-full border-4 border-gray-100 shadow-md"
                            />
                            <h3 className="text-xl font-bold text-gray-900">
                                {data.name}
                            </h3>
                            <p className="mb-6 text-sm text-gray-500">
                                {data.email}
                            </p>

                            {/* Tombol Upload (Styled) */}
                            <label
                                htmlFor="logoUpload"
                                className="block w-full cursor-pointer rounded-full bg-gray-100 px-4 py-3 font-bold text-gray-800 transition-colors hover:bg-gray-200"
                            >
                                Ubah Logo
                            </label>
                            <input
                                type="file"
                                id="logoUpload"
                                className="hidden"
                                accept="image/*"
                                onChange={(e) =>
                                    setData(
                                        'logo',
                                        e.target.files ? e.target.files[0] : null,
                                    )
                                }
                            />
                            <p className="mt-2 text-xs text-gray-400">
                                JPG, PNG, atau SVG. Maks 2MB.
                            </p>
                        </div>
                    </div>

                    {/* === KOLOM KANAN (Form Detail) === */}
                    <div className="lg:col-span-2">
                        <div className="rounded-[2.5rem] bg-white p-8 shadow-sm">
                            <h3 className="mb-6 border-b border-gray-200 pb-4 text-xl font-bold text-gray-900">
                                Detail Organisasi
                            </h3>

                            <div className="space-y-6">
                                {/* Nama Organisasi */}
                                <div>
                                    <label
                                        htmlFor="name"
                                        className="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Nama Organisasi
                                    </label>
                                    <input
                                        type="text"
                                        id="name"
                                        value={data.name}
                                        onChange={handleChange}
                                        className="w-full rounded-lg border-gray-300 px-2 py-2 text-gray-700 shadow-sm focus:border-saintara-yellow focus:ring-saintara-yellow"
                                    />
                                    {errors.name && (
                                        <p className="mt-1 text-xs text-red-500">
                                            {errors.name}
                                        </p>
                                    )}
                                </div>

                                {/* Grid Email & Telepon */}
                                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label
                                            htmlFor="email"
                                            className="mb-2 block text-sm font-bold text-gray-700"
                                        >
                                            Email Kontak
                                        </label>
                                        <input
                                            type="email"
                                            id="email"
                                            value={data.email}
                                            onChange={handleChange}
                                            className="w-full rounded-lg border-gray-300 px-2 py-2 text-gray-700 shadow-sm focus:border-saintara-yellow focus:ring-saintara-yellow"
                                        />
                                        {errors.email && (
                                            <p className="mt-1 text-xs text-red-500">
                                                {errors.email}
                                            </p>
                                        )}
                                    </div>
                                    <div>
                                        <label
                                            htmlFor="phone"
                                            className="mb-2 block text-sm font-bold text-gray-700"
                                        >
                                            No. Telepon
                                        </label>
                                        <input
                                            type="tel"
                                            id="phone"
                                            value={data.phone}
                                            onChange={handleChange}
                                            className="w-full rounded-lg border-gray-300 px-2 py-2 text-gray-700 shadow-sm focus:border-saintara-yellow focus:ring-saintara-yellow"
                                        />
                                        {errors.phone && (
                                            <p className="mt-1 text-xs text-red-500">
                                                {errors.phone}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                {/* Website */}
                                <div>
                                    <label
                                        htmlFor="website"
                                        className="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Website
                                    </label>
                                    <input
                                        type="text"
                                        id="website"
                                        value={data.website}
                                        onChange={handleChange}
                                        placeholder="https://domain.com"
                                        className="w-full rounded-lg border-gray-300 px-2 py-2 text-gray-700 shadow-sm focus:border-saintara-yellow focus:ring-saintara-yellow"
                                    />
                                    {errors.website && (
                                        <p className="mt-1 text-xs text-red-500">
                                            {errors.website}
                                        </p>
                                    )}
                                </div>

                                {/* Alamat */}
                                <div>
                                    <label
                                        htmlFor="address"
                                        className="mb-2 block text-sm font-bold text-gray-700"
                                    >
                                        Alamat Lengkap
                                    </label>
                                    <textarea
                                        id="address"
                                        value={data.address}
                                        onChange={handleChange}
                                        rows={3}
                                        className="w-full rounded-lg border-gray-300 px-2 py-2 text-gray-700 shadow-sm focus:border-saintara-yellow focus:ring-saintara-yellow"
                                    />
                                    {errors.address && (
                                        <p className="mt-1 text-xs text-red-500">
                                            {errors.address}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Tombol Aksi (Simpan) */}
                <div className="mt-0 flex justify-end">
                    <button
                        type="submit"
                        disabled={processing}
                        className="rounded-full bg-saintara-yellow px-8 py-3 font-bold text-gray-900 shadow-md transition-colors hover:bg-yellow-500 disabled:opacity-50"
                    >
                        {processing ? 'Menyimpan...' : 'Simpan Perubahan'}
                    </button>
                </div>
            </form>
        </InstansiLayout>
    );
}
