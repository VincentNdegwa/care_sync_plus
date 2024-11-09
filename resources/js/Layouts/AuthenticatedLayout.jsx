import ApplicationLogo from "@/Components/ApplicationLogo";
import Dropdown from "@/Components/Dropdown";
import axiosInstance from "@/customAxios";
import { Link, router, usePage } from "@inertiajs/react";
import { useEffect, useState } from "react";
import LoadingUi from "../Pages/Ui/LoadinUI";
import RedirectinUi from "@/Pages/Ui/RedirectingUI";
import Unauthorized from "@/Pages/Ui/Unauthorized";

const axios = axiosInstance;

export default function AuthenticatedLayout({ header, children }) {
    const [showSidebar, setShowSidebar] = useState(true);
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios
            .get("/checkTokenIsValid")
            .then((response) => {
                if (response.data.error === false) {
                    setUser(response.data.user);
                } else {
                    router.get(route("login"));
                }
            })
            .catch(() => {
                router.get(route("login"));
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    const handleLogout = () => {
        axios
            .post("/logout")
            .then(() => {
                router.get(route("login"));
                localStorage.removeItem("token");
            })
            .catch((error) => {
                console.error("Logout error:", error);
            });
    };

    if (loading) {
        return <LoadingUi />;
    }

    if (!user) {
        return <Unauthorized />;
    }

    return (
        <div className="flex min-h-screen bg-gray-100">
            {/* Sidebar */}
            <aside className="w-64 bg-white shadow-lg">
                <div className="p-6">
                    <Link href="/">
                        <ApplicationLogo className="block h-9 w-auto fill-current text-gray-800" />
                    </Link>
                    <div className="mt-8 space-y-2">
                        <Link
                            href={route("dashboard")}
                            className="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md"
                        >
                            Dashboard
                        </Link>
                        <Link
                            href={route("profile.edit")}
                            className="block px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-md"
                        >
                            Profile
                        </Link>
                        <button
                            onClick={handleLogout}
                            className="w-full px-4 py-2 text-left text-gray-600 hover:bg-gray-100 rounded-md"
                        >
                            Log Out
                        </button>
                    </div>
                </div>
            </aside>

            {/* Main Content */}
            <div className="flex-1">
                <header className="bg-white shadow">
                    <div className="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {header}
                    </div>
                </header>
                <main className="p-6">{children}</main>
            </div>
        </div>
    );
}
