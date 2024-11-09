export default function RedirectinUi() {
    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-100">
                <div className="bg-white p-6 rounded-lg shadow-lg text-center">
                    <div className="flex justify-center items-center">
                        <svg className="animate-spin h-12 w-12 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <circle className="opacity-25" cx="12" cy="12" r="10" strokeWidth="4"></circle>
                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 0116 0h-4a4 4 0 00-8 0H4z"></path>
                        </svg>
                    </div>
                    <p className="text-gray-700 mt-4">You are not authenticated. Redirecting to login...</p>
                </div>
            </div>
        );
}
