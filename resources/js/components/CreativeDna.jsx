import React, { useRef, useState } from 'react';
import axios from 'axios';
import Navbar from './Navbar';

const MIN_FILES = 20;
const MAX_FILES = 30;

export default function CreativeDna() {
    const [files, setFiles] = useState([]);
    const [uploading, setUploading] = useState(false);
    const [toast, setToast] = useState(null);
    const inputRef = useRef(null);

    const showToast = (message, type = 'error') => {
        setToast({ message, type });
        setTimeout(() => setToast(null), 4000);
    };

    const handleSelect = (e) => {
        const all = Array.from(e.target.files);
        const selected = all.slice(0, MAX_FILES);
        setFiles(selected);

        if (all.length > MAX_FILES) {
            showToast(
                `You can upload a maximum of ${MAX_FILES} images. Only the first ${MAX_FILES} were kept.`
            );
        } else if (selected.length < MIN_FILES) {
            showToast(
                `Please select at least ${MIN_FILES} image files. You selected ${selected.length}.`
            );
        }
    };

    const handleUpload = async () => {
        if (files.length < MIN_FILES || files.length > MAX_FILES) {
            showToast(`Please select between ${MIN_FILES} and ${MAX_FILES} image files.`);
            return;
        }

        setUploading(true);
        const data = new FormData();
        files.forEach((file) => data.append('files[]', file));

        try {
            await axios.post('/creative-dna/upload', data);
            showToast('Upload successful. Your Creative DNA is ready.', 'success');

            // O Creative DNA é usado apenas uma vez — segue para o Moodboard
            setTimeout(() => (window.location.href = '/moodboard'), 900);
        } catch (err) {
            showToast(err.response?.data?.message || 'Upload failed. Please try again.');
        } finally {
            setUploading(false);
        }
    };

    const handleLogout = async () => {
        try {
            await axios.post('/logout');
        } finally {
            window.location.href = '/login';
        }
    };

    return (
        <div className="cdna">
            {toast && <div className={`cdna-toast cdna-toast--${toast.type}`}>{toast.message}</div>}

            <Navbar actions={[{ label: 'Logout', onClick: handleLogout, variant: 'ghost' }]} />

            <main className="cdna__main">
                <h1 className="cdna__title">Creative DNA</h1>
                <p className="cdna__subtitle">
                    Upload at least {MIN_FILES} images that inspire your fashion design.
                </p>

                <div
                    className="cdna__dropzone"
                    onClick={() => inputRef.current?.click()}
                    onDragOver={(e) => e.preventDefault()}
                    onDrop={(e) => {
                        e.preventDefault();
                        handleSelect({ target: { files: e.dataTransfer.files } });
                    }}
                >
                    <input
                        ref={inputRef}
                        type="file"
                        accept="image/*"
                        multiple
                        hidden
                        onChange={handleSelect}
                    />
                    <span className="cdna__dropzone-icon">+</span>
                    <p className="cdna__dropzone-text">Click or drag your images here</p>
                    <p className="cdna__dropzone-hint">JPG, PNG — between {MIN_FILES} and {MAX_FILES} files</p>
                </div>

                <div className="cdna__meta">
                    <span className={`cdna__count ${files.length >= MIN_FILES ? 'cdna__count--ok' : ''}`}>
                        {files.length} / {MIN_FILES}–{MAX_FILES} images selected
                    </span>
                    {files.length > 0 && files.length < MIN_FILES && (
                        <span className="cdna__warn">At least {MIN_FILES} images required.</span>
                    )}
                </div>

                <div className="cdna__actions">
                    <button
                        type="button"
                        className="cdna__upload"
                        onClick={handleUpload}
                        disabled={uploading || files.length < MIN_FILES || files.length > MAX_FILES}
                    >
                        {uploading ? 'Uploading...' : 'Upload images'}
                    </button>

                    <button
                        type="button"
                        className="cdna__moodboard"
                        disabled={files.length < MIN_FILES}
                        onClick={() => (window.location.href = '/moodboard')}
                    >
                        My Moodboard
                    </button>
                </div>
            </main>
        </div>
    );
}
