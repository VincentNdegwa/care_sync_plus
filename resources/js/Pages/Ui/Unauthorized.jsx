export default function Unauthorized() {
    return (
         <div className="min-h-screen flex items-center justify-center bg-gray-100">
                <div className="bg-white p-6 rounded-lg shadow-lg text-center">
                    <p className="text-gray-700">Not authenticated, please log in to continue.</p>
                </div>
        </div>
    )
}
