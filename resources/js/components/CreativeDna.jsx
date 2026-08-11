import React, { useRef, useState } from 'react';
import axios from 'axios';
import Navbar from './Navbar';

const MIN_FILES = 20;
const MAX_FILES = 30;

export default function CreativeDna() {
    const [files, setFiles] = useState([]); // [{ file, url }]
    const [uploading, setUploading] = useState(false);
    const [dragging, setDragging] = useState(false);
    const [toast, setToast] = useState(null);
    const inputRef = useRef(null);

    const showToast = (message, type = 'error') => {
        setToast({ message, type });
        setTimeout(() => setToast(null), 4000);
    };

    const handleSelect = (e) => {
        const all = Array.from(e.target.files || []);
        const selected = all.slice(0, MAX_FILES).map((file) => ({
            file,
            url: URL.createObjectURL(file),
        }));

        setFiles((prev) => {
            prev.forEach((item) => URL.revokeObjectURL(item.url));
            return selected;
        });

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

    const removeFile = (index) => {
        setFiles((prev) => {
            const item = prev[index];
            if (item) URL.revokeObjectURL(item.url);
            return prev.filter((_, i) => i !== index);
        });
    };

    const handleUpload = async () => {
        if (files.length < MIN_FILES || files.length > MAX_FILES) {
            showToast(`Please select between ${MIN_FILES} and ${MAX_FILES} image files.`);
            return;
        }

        setUploading(true);
        const data = new FormData();
        files.forEach(({ file }) => data.append('files[]', file));

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

    const progress = Math.min((files.length / MAX_FILES) * 100, 100);

    return (
        <div className="cdna">
            {toast && <div className={`cdna-toast cdna-toast--${toast.type}`}>{toast.message}</div>}

            <Navbar actions={[{ label: 'Logout', onClick: handleLogout, variant: 'ghost' }]} />

            <main className="cdna__main">
                <p className="cdna__kicker">MOOD.X — Creative Studio</p>
                <h1 className="cdna__title">Creative DNA</h1>
                <p className="cdna__subtitle">
                    Upload at least {MIN_FILES} images that inspire your fashion design.
                </p>
                <p className="cdna__note">
                    These images define your DNA as a designer. Once created, your Creative DNA
                    cannot be edited, and it will be used to generate a result with AI.
                </p>

                {/* Arrasta sobre a área → onDragEnter → destaca (dragover)
                     Sai da área sem soltar → onDragLeave → desfaz o destaque
                     Solta na área → onDrop → processa as imagens */}

                <div
                    // arrastar e soltar ficheiros -- dropzone
                    className={`cdna__dropzone ${dragging ? 'cdna__dropzone--dragover' : ''}`}
                    onClick={() => inputRef.current?.click()}
                    onDragEnter={(e) => {
                        e.preventDefault();
                        setDragging(true);
                    }}
                    //dragging: "acende" a borda e muda o fundo 
                    onDragOver={(e) => e.preventDefault()}
                    onDragLeave={(e) => {
                        e.preventDefault();
                        setDragging(false);
                    }}
                    onDrop={(e) => {
                        e.preventDefault();
                        setDragging(false);
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

                <p className="cdna__steps">
                    After your images are loaded, click “Upload images” and then “My Moodboard”.
                </p>

                {files.length > 0 && (
                    <div className="cdna__previews">
                        {files.map((item, i) => (
                            <div
                                key={item.url}
                                className={`cdna__preview ${i === 0 ? 'cdna__preview--first' : ''}`}
                            >
                                <img src={item.url} alt="" />
                                <button
                                    type="button"
                                    className="cdna__preview__remove"
                                    onClick={() => removeFile(i)}
                                    aria-label="Remove"
                                >
                                    &times;
                                </button>
                            </div>
                        ))}
                    </div>
                )}

                <div className="cdna__meta">
                    <span className={`cdna__count ${files.length >= MIN_FILES ? 'cdna__count--ok' : ''}`}>
                        {files.length} / {MIN_FILES}–{MAX_FILES} images selected
                    </span>
                    {files.length > 0 && files.length < MIN_FILES && (
                        <span className="cdna__warn">At least {MIN_FILES} images required.</span>
                    )}
                </div>

                <div className="cdna__progress">
                    <div className="cdna__progress-track">
                        <span className="cdna__progress-marker" />
                        <div
                            className={`cdna__progress-fill ${files.length >= MIN_FILES ? 'cdna__progress-fill--ok' : ''}`}
                            style={{ width: `${progress}%` }}
                        />
                    </div>
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
