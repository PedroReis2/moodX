/**
 * Entrada React para as páginas que usam o bundle Vite.
 * Monta os componentes React nos pontos de montagem da página.
 */
import React from 'react';
import { createRoot } from 'react-dom/client';
import Login from './components/auth/Login';
import Register from './components/auth/Register';
import CreativeDna from './components/CreativeDna';
import Projects from './components/Projects';


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

// Página Creative DNA (React)
const creativeDnaRoot = document.getElementById('creative-dna-root');
if (creativeDnaRoot) {
    createRoot(creativeDnaRoot).render(
        <React.StrictMode>
            <CreativeDna userName={creativeDnaRoot.dataset.userName || ''} />
        </React.StrictMode>
    );
}

// Página Projects (React)
const projectsRoot = document.getElementById('projects-root');
if (projectsRoot) {
    createRoot(projectsRoot).render(
        <React.StrictMode>
            <Projects userName={projectsRoot.dataset.userName || ''} />
        </React.StrictMode>
    );
}
