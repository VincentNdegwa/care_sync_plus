import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import GuestLayout from "@/Layouts/GuestLayout";
import { Head, router } from "@inertiajs/react";
import { useState } from "react";
import axiosInstance from "@/customAxios";

const axios = axiosInstance;

export default function ResetPassword({ token, email }) {
    const [data, setData] = useState({
        token: token,
        email: email,
        password: "",
        password_confirmation: "",
    });

    const [successMessage, setSuccessMessage] = useState("");
    const [isProcessing, setIsProcessing] = useState(false);
    const [errors, setErrors] = useState({});

    const submit = (e) => {
        e.preventDefault();
        setIsProcessing(true);

        axios
            .post("/resetPassword", data)
            .then((response) => {
                if (response.data.error) {
                    if (response.data.errors) {
                        setErrors(response.data.errors);
                    } else {
                        alert(response.data.message);
                    }
                } else {
                    setSuccessMessage(response.data.message);

                    setTimeout(() => {
                        router.get(route("login"));
                    }, 1000);
                    setErrors({});
                }
            })
            .catch((error) => {
                alert("An unexpected error occurred. Please try again later.");
                console.error(error);
            })
            .finally(() => {
                setIsProcessing(false);
                setData((prevData) => ({
                    ...prevData,
                    password: "",
                    password_confirmation: "",
                }));
            });
    };

    return (
        <GuestLayout>
            <Head title="Reset Password" />

            <form onSubmit={submit}>
                {successMessage && (
                    <div className="mb-4 text-sm font-medium text-green-600">
                        {successMessage}
                    </div>
                )}

                <div>
                    <InputLabel htmlFor="email" value="Email" />
                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="mt-1 block w-full"
                        autoComplete="username"
                        onChange={(e) =>
                            setData({ ...data, email: e.target.value })
                        }
                    />
                    <InputError message={errors.email} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel htmlFor="password" value="Password" />
                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        isFocused={true}
                        onChange={(e) =>
                            setData({ ...data, password: e.target.value })
                        }
                    />
                    <InputError message={errors.password} className="mt-2" />
                </div>

                <div className="mt-4">
                    <InputLabel
                        htmlFor="password_confirmation"
                        value="Confirm Password"
                    />
                    <TextInput
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        value={data.password_confirmation}
                        className="mt-1 block w-full"
                        autoComplete="new-password"
                        onChange={(e) =>
                            setData({
                                ...data,
                                password_confirmation: e.target.value,
                            })
                        }
                    />
                    <InputError
                        message={errors.password_confirmation}
                        className="mt-2"
                    />
                </div>

                <div className="mt-4 flex items-center justify-end">
                    <PrimaryButton className="ms-4" disabled={isProcessing}>
                        Reset Password
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
