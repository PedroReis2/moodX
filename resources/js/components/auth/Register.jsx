import React, { useState } from 'react';
import axios from 'axios';

/**
 * Página de Registo em React (substitui o formulário Blade).
 * Faz POST multipart para a rota /store_user e trata erros de validação.
 */
export default function Register() {
    const [form, setForm] = useState({
        first_name: '',
        last_name: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
    });
    const [profileImage, setProfileImage] = useState(null);
    const [preview, setPreview] = useState('https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg');
    const [errors, setErrors] = useState([]);
    const [loading, setLoading] = useState(false);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (!file) return;

        setProfileImage(file);

        const reader = new FileReader();
        reader.onload = (ev) => setPreview(ev.target.result);
        reader.readAsDataURL(file);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrors([]);
        setLoading(true);

        const data = new FormData();
        data.append('first_name', form.first_name);
        data.append('last_name', form.last_name);
        data.append('username', form.username);
        data.append('email', form.email);
        data.append('password', form.password);
        data.append('password_confirmation', form.password_confirmation);
        if (profileImage) {
            data.append('profile_image', profileImage);
        }

        try {
            // O backend cria a conta e responde com redirect (302) para /dashboard.
            // No browser, o XHR segue o redirect; como o utilizador não é autenticado
            // automaticamente, o /dashboard (protegido) responde 401.
            // Ambos os casos significam "conta criada com sucesso".
            await axios.post('/store_user', data, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });

            // Se chegámos aqui sem exceção -> conta criada
            window.location.href = '/login';
        } catch (err) {
            // 401 = conta criada mas o redirect para /dashboard falhou (não autenticado)
            if (err.response && err.response.status === 401) {
                window.location.href = '/login';
                return;
            }

            setLoading(false);

            if (err.response && err.response.status === 422) {
                const validationErrors = err.response.data.errors;
                const flat = Object.values(validationErrors || {}).flat();
                setErrors(flat.length ? flat : ['Unable to create account. Please check your details.']);
            } else if (err.response && err.response.data && err.response.data.message) {
                setErrors([err.response.data.message]);
            } else {
                setErrors(['Something went wrong. Please try again.']);
            }
        }
    };

    return (
        <div className="register-page container-fluid">
            <div className="header-container mx-auto" style={{ maxWidth: 1062, position: 'relative' }}>

                {/* Logo */}
                <div className="layout-logo">
                    <img src="/images/logo.png" className="logo-img raise-up" alt="Logo" />
                </div>

                {/* Título */}
                <div className="title-outside">
                    <h1 className="page-title">CREATE ACCOUNT</h1>
                </div>

                {/* Botão de fechar */}
                <div className="close-button-container">
                    <a href="/dashboard" className="close-button">
                        <i className="fa-solid fa-xmark"></i>
                    </a>
                </div>

                <div className="white-rectangle mx-auto">
                    {errors.length > 0 && (
                        <div className="alert alert-danger mt-3">
                            <ul className="mb-0">
                                {errors.map((error, i) => (
                                    <li key={i}>{error}</li>
                                ))}
                            </ul>
                        </div>
                    )}

                    <div className="row align-items-center w-100">

                        {/* Coluna esquerda: foto de perfil */}
                        <div className="col-12 col-md-5 d-flex flex-column align-items-center mb-4 mb-md-0">
                            <div className="profile-pic-wrapper">
                                <div className="circle">
                                    <img
                                        id="profilePreview"
                                        className="profile-pic"
                                        src={preview}
                                        alt="Profile Picture"
                                    />
                                </div>
                                <div className="p-image" onClick={() => document.getElementById('profileImageInput').click()}>
                                    <i className="fa fa-camera upload-button"></i>
                                </div>
                            </div>
                        </div>

                        {/* Coluna direita: formulário */}
                        <div className="col-12 col-md-7">
                            <div className="form-column">
                                <form className="create_account_form" onSubmit={handleSubmit} encType="multipart/form-data">
                                    <input
                                        type="file"
                                        name="profile_image"
                                        id="profileImageInput"
                                        style={{ display: 'none' }}
                                        accept="image/*"
                                        onChange={handleImageChange}
                                    />

                                    <div className="form-floating">
                                        <input
                                            type="text"
                                            className="form-control"
                                            id="first_name"
                                            name="first_name"
                                            placeholder="First Name"
                                            value={form.first_name}
                                            onChange={handleChange}
                                            required
                                        />
                                    </div>

                                    <div className="form-floating">
                                        <input
                                            type="text"
                                            className="form-control"
                                            id="last_name"
                                            name="last_name"
                                            placeholder="Last Name"
                                            value={form.last_name}
                                            onChange={handleChange}
                                            required
                                        />
                                    </div>

                                    <div className="form-floating">
                                        <input
                                            type="text"
                                            className="form-control"
                                            id="username"
                                            name="username"
                                            placeholder="Username"
                                            value={form.username}
                                            onChange={handleChange}
                                            required
                                        />
                                    </div>

                                    <div className="form-floating">
                                        <input
                                            type="email"
                                            className="form-control"
                                            id="email"
                                            name="email"
                                            placeholder="Email"
                                            value={form.email}
                                            onChange={handleChange}
                                            required
                                        />
                                    </div>

                                    <div className="form-floating">
                                        <input
                                            type="password"
                                            className="form-control"
                                            id="password"
                                            name="password"
                                            placeholder="Password"
                                            value={form.password}
                                            onChange={handleChange}
                                            required
                                        />
                                    </div>

                                    <div className="form-floating">
                                        <input
                                            type="password"
                                            className="form-control"
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            placeholder="Confirm Password"
                                            value={form.password_confirmation}
                                            onChange={handleChange}
                                            required
                                        />
                                    </div>

                                    <div className="text-end">
                                        <button type="submit" className="button button_wide" disabled={loading}>
                                            {loading ? 'Saving...' : 'Save'}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
