import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import axiosInstance from "@/customAxios";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head } from "@inertiajs/react";
import { useState } from "react";

const axios = axiosInstance;
export default function ForgotPassword() {
    const [sucessMessage, setSuccessMessage] = useState("");
    const [isProcessing, setIsProcessing] = useState(false);
    const [data, setData] = useState({
        email: "",
    });
    const [errors, setErrors] = useState({
        email: "",
    });

    const submit = (e) => {
        e.preventDefault();
        setIsProcessing(true);
        axios
            .post("/forgotPassword", data)
            .then((response) => {
                if (response.data.error) {
                    if (response.data.errors) {
                        setErrors(response.data.errors);
                    } else {
                        alert(response.data.message);
                    }
                }

                if (response.data.error == false) {
                    setSuccessMessage(response.data.message);
                }
            })
            .catch((error) => {
                alert(
                    "An error occurred while sending password reset email. Please try again."
                );
                console.log(error);
            })
            .finally(() => {
                setIsProcessing(false);
            });
        post(route("password.email"));
    };

    return (
        <GuestLayout>
            <Head title="Forgot Password" />

            <div className="mb-4 text-sm text-gray-600">
                Forgot your password? No problem. Just let us know your email
                address and we will email you a password reset link that will
                allow you to choose a new one.
            </div>

            {sucessMessage && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {sucessMessage}
                </div>
            )}

            <form onSubmit={submit}>
                <TextInput
                    id="email"
                    type="email"
                    name="email"
                    value={data.email}
                    className="mt-1 block w-full"
                    isFocused={true}
                    onChange={(e) => setData({ email: e.target.value })}
                />

                <InputError message={errors.email} className="mt-2" />

                <div className="mt-4 flex items-center justify-end">
                    <PrimaryButton className="ms-4" disabled={isProcessing}>
                        Email Password Reset Link
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
