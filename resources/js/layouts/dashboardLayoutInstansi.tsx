import { Link, usePage } from '@inertiajs/react';
import type { ReactNode } from 'react';
import {
    HiBell,
    HiCog,
    HiCreditCard,
    HiDocumentReport,
    HiDocumentText,
    HiHome,
    HiSupport,
    HiUserCircle,
} from 'react-icons/hi';

// Tipe props global dari Inertia (disesuaikan dengan share('auth') di Laravel)
type PageProps = {
    auth: {
        user: {
            name: string;
            email: string;
        } | null;
    };
};

type MenuItem = {
    name: string;
    href: string;
    icon: React.ComponentType<React.SVGProps<SVGSVGElement>>;
};

const menuItems: MenuItem[] = [
    {
        name: 'Dashboard',
        href: '/instansi/dashboardInstansi',
        icon: HiHome,
    },
    {
        name: 'Profil Organisasi',
        href: '/instansi/profilInstansi',
        icon: HiUserCircle,
    },
    {
        name: 'Daftar Tes Karakter',
        href: '/instansi/tesInstansi', // ini mengarah ke InstansiTesController@index
        icon: HiDocumentText,
    },
    {
        name: 'Transaksi & Voucher',
        href: '/instansi/transaksiInstansi',
        icon: HiCreditCard,
    },
    {
        name: 'Hasil Tes',
        href: '/instansi/hasilInstansi',
        icon: HiDocumentReport,
    },
    {
        name: 'Bantuan',
        href: '/instansi/bantuanInstansi',
        icon: HiSupport,
    },
    {
        name: 'Pengaturan',
        href: '/instansi/pengaturanInstansi',
        icon: HiCog,
    },
];

export default function InstansiLayout({ children }: { children: ReactNode }) {
    const { url, props } = usePage<PageProps>();
    const user = props.auth.user;

    // Inisial untuk avatar (diambil dari nama user)
    const initials =
        user?.name
            ?.split(' ')
            .map((w) => w.charAt(0))
            .join('')
            .substring(0, 2)
            .toUpperCase() ?? 'US';

    // Avatar dinamis pakai ui-avatars (optional)
    const avatarUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(
        user?.name ?? 'User',
    )}&background=FACC15&color=000&size=128`;

    return (
        <div className="flex min-h-screen bg-gray-50 font-poppins">
            {/* === SIDEBAR === */}
            <aside className="flex w-64 flex-shrink-0 flex-col bg-saintara-black text-white transition-all duration-300">
                {/* Logo */}
                <div className="flex h-20 items-center justify-center border-b border-gray-700">
                    <Link href="/" className="flex items-center gap-3">
                        <div className="flex h-8 w-8 items-center justify-center rounded-full bg-white text-xs font-bold text-saintara-black">
                            {initials}
                        </div>
                        <h1 className="cursor-pointer text-2xl font-bold tracking-wider text-white transition-colors hover:text-saintara-yellow">
                            SAINTARA
                        </h1>
                    </Link>
                </div>

                {/* Menu Navigasi */}
                <nav className="flex-1 space-y-2 px-4 py-6">
                    {menuItems.map((item) => {
                        const isActive = url.startsWith(item.href);

                        return (
                            <Link
                                key={item.name}
                                href={item.href}
                                className={`group flex items-center rounded-lg px-4 py-2.5 transition-all duration-300 ${
                                    isActive
                                        ? 'bg-saintara-yellow font-bold text-gray-900 shadow-md'
                                        : 'text-gray-300 hover:bg-gray-700 hover:text-white'
                                }`}
                            >
                                <item.icon
                                    className={`mr-3 h-6 w-6 transition-colors ${
                                        isActive
                                            ? 'text-gray-900'
                                            : 'text-gray-400 group-hover:text-saintara-yellow'
                                    }`}
                                />
                                {item.name}
                            </Link>
                        );
                    })}
                </nav>
            </aside>

            {/* === KONTEN UTAMA === */}
            <div className="flex flex-1 flex-col overflow-hidden">
                {/* HEADER */}
                <header className="flex h-20 items-center justify-between border-b border-gray-100 bg-white px-8 shadow-sm">
                    <h2 className="text-2xl font-bold text-gray-800">
                        Selamat datang, {user?.name ?? 'Pengguna'}!
                    </h2>

                    <div className="flex items-center space-x-3">
                        <Link
                            href="/instansi/profilInstansi"
                            className="flex cursor-pointer items-center rounded-full bg-saintara-yellow px-4 py-2 shadow-md transition-all duration-200 hover:shadow-lg"
                        >
                            <div className="mr-2 h-9 w-9 overflow-hidden rounded-full bg-gray-200">
                                <img
                                    src={avatarUrl}
                                    alt={user?.name ?? 'Avatar'}
                                    className="h-full w-full object-cover"
                                />
                            </div>

                            <div className="text-sm">
                                <p className="font-bold leading-none text-gray-900">
                                    {user?.name ?? 'Pengguna'}
                                </p>
                                <p className="text-xs leading-none text-gray-700">
                                    {user?.email ?? 'email@tidak-diketahui'}
                                </p>
                            </div>
                        </Link>

                        <button
                            type="button"
                            className="relative flex h-11 w-11 items-center justify-center rounded-full bg-saintara-yellow text-gray-900 shadow-md transition-colors hover:bg-yellow-500"
                        >
                            <HiBell className="h-6 w-6" />
                            <span className="absolute top-1 right-1 h-3 w-3 rounded-full border-2 border-white bg-red-600" />
                        </button>
                    </div>
                </header>

                {/* KONTEN DINAMIS */}
                <main className="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
                    {children}
                </main>
            </div>
        </div>
    );
}
