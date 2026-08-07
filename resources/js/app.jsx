/**
 * Entrada React para as páginas que usam o bundle Vite.
 * Monta os componentes React nos pontos de montagem da página.
 */
import React from 'react';
import { createRoot } from 'react-dom/client';
import Login from './components/auth/Login';
import Register from './components/auth/Register';

// Página de Login (React)
const loginRoot = document.getElementById('login-root');
if (loginRoot) {
    createRoot(loginRoot).render(
        <React.StrictMode>
            <Login />
        </React.StrictMode>
    );
}

// Página de Registo (React)
const registerRoot = document.getElementById('register-root');
if (registerRoot) {
    createRoot(registerRoot).render(
        <React.StrictMode>
            <Register />
        </React.StrictMode>
    );
}
