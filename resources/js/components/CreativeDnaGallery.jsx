import React, { useEffect, useState } from 'react';
import axios from 'axios';
import Navbar from './Navbar';

/**
 * Galeria do Creative DNA — página de visualização (só leitura).
 * Mostra as imagens que o utilizador carregou para definir o seu DNA.
 * O utilizador não pode editar/remover nada aqui.
 */
export default function CreativeDnaGallery({ userName = '' }) {
    const [images, setImages] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    useEffect(() => {
        axios
            .get('/creative-dna/images')
            .then(({ data }) => setImages(data.images || []))
            .catch(() => setError('Unable to load your Creative DNA images.'))
            .finally(() => setLoading(false));
    }, []);

    const logout = async () => {
        try {
            await axios.post('/logout');
        } finally {
            window.location.href = '/login';
        }
    };

    return (
        <div className="cdg">
            <Navbar
                userName={userName}
                actions={[
                    {
                        label: 'Projects',
                        onClick: () => {
                            window.location.href = '/projects';
                        },
                        variant: 'ghost',
                    },
                    { label: 'Logout', onClick: logout, variant: 'ghost' },
                ]}
            />

            <main className="cdg__main">
                <header className="cdg__header">
                    <p className="cdna__kicker">MOOD.X — Creative Studio</p>
                    <h1 className="cdna__title">Creative DNA</h1>
                    <p className="cdg__note">
                        These are the images you uploaded to define your Creative DNA.
                    </p>
                </header>

                {error ? (
                    <p className="cdg__empty">{error}</p>
                ) : loading ? (
                    <p className="cdg__empty">Loading your images...</p>
                ) : images.length === 0 ? (
                    <p className="cdg__empty">No images found.</p>
                ) : (
                    <>
                        <p className="cdg__count">
                            {images.length} {images.length === 1 ? 'image' : 'images'}
                        </p>
                        <div className="cdg__grid">
                            {images.map((image) => (
                                <figure key={image.url} className="cdg__item">
                                    <img
                                        src={image.url}
                                        alt={image.name || 'Creative DNA image'}
                                        loading="lazy"
                                    />
                                </figure>
                            ))}
                        </div>
                    </>
                )}
            </main>
        </div>
    );
}
