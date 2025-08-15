import React from 'react';
import { AppShell } from '@/components/app-shell';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { router } from '@inertiajs/react';
import { ArrowLeft, Edit, Plus, Book, User, Calendar, Globe, Tag } from 'lucide-react';

interface StorybookPage {
    id: number;
    page_number: number;
    text_content: Record<string, string>;
    image_path: string | null;
    audio_paths: Record<string, string> | null;
    created_at: string;
    updated_at: string;
}

interface Storybook {
    id: number;
    title: string;
    author: string;
    cover_image: string | null;
    languages: string[];
    description: string | null;
    status: 'draft' | 'published' | 'archived';
    page_count: number;
    age_group: string | null;
    tags: string[] | null;
    created_at: string;
    updated_at: string;
    pages: StorybookPage[];
}

interface Props {
    storybook: Storybook;
    [key: string]: unknown;
}

export default function ShowStorybook({ storybook }: Props) {
    const getStatusColor = (status: string) => {
        switch (status) {
            case 'published':
                return 'bg-green-100 text-green-800';
            case 'draft':
                return 'bg-yellow-100 text-yellow-800';
            case 'archived':
                return 'bg-gray-100 text-gray-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    };

    const getLanguageFlag = (lang: string) => {
        return lang === 'en' ? '🇺🇸' : '🇮🇳';
    };

    return (
        <AppShell>
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center gap-4">
                    <Button
                        variant="outline"
                        onClick={() => router.visit('/storybooks')}
                        className="flex items-center gap-2"
                    >
                        <ArrowLeft className="h-4 w-4" />
                        Back to Library
                    </Button>
                    <div className="flex-1">
                        <div className="flex items-center gap-3 mb-2">
                            <Heading 
                                title={`📖 ${storybook.title}`}
                                className="flex items-center gap-2"
                            />
                            <Badge className={getStatusColor(storybook.status)}>
                                {storybook.status}
                            </Badge>
                        </div>
                        <div className="flex items-center gap-4 text-sm text-muted-foreground">
                            <span className="flex items-center gap-1">
                                <User className="h-3 w-3" />
                                {storybook.author}
                            </span>
                            <span className="flex items-center gap-1">
                                <Book className="h-3 w-3" />
                                {storybook.page_count} pages
                            </span>
                            <span className="flex items-center gap-1">
                                <Calendar className="h-3 w-3" />
                                {new Date(storybook.created_at).toLocaleDateString()}
                            </span>
                        </div>
                    </div>
                    <Button
                        onClick={() => router.visit(`/storybooks/${storybook.id}/edit`)}
                        className="flex items-center gap-2"
                    >
                        <Edit className="h-4 w-4" />
                        Edit Storybook
                    </Button>
                </div>

                {/* Story Info */}
                <div className="grid md:grid-cols-3 gap-6">
                    <div className="md:col-span-2 space-y-6">
                        {/* Description */}
                        {storybook.description && (
                            <Card>
                                <CardHeader>
                                    <CardTitle>📝 Story Description</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="text-gray-700">{storybook.description}</p>
                                </CardContent>
                            </Card>
                        )}

                        {/* Pages */}
                        <Card>
                            <CardHeader>
                                <div className="flex items-center justify-between">
                                    <CardTitle className="flex items-center gap-2">
                                        📄 Story Pages
                                    </CardTitle>
                                    <Button
                                        onClick={() => router.visit(`/storybooks/${storybook.id}/pages/create`)}
                                        className="flex items-center gap-2"
                                    >
                                        <Plus className="h-4 w-4" />
                                        Add Page
                                    </Button>
                                </div>
                            </CardHeader>
                            <CardContent>
                                {storybook.pages.length > 0 ? (
                                    <div className="grid gap-4">
                                        {storybook.pages.map((page) => (
                                            <div
                                                key={page.id}
                                                className="p-4 border rounded-lg hover:bg-gray-50 cursor-pointer"
                                                onClick={() => router.visit(`/storybooks/${storybook.id}/pages/${page.id}`)}
                                            >
                                                <div className="flex items-start gap-4">
                                                    <div className="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">
                                                        Page {page.page_number}
                                                    </div>
                                                    <div className="flex-1">
                                                        <div className="space-y-2">
                                                            {Object.entries(page.text_content).map(([lang, text]) => (
                                                                <div key={lang}>
                                                                    <div className="flex items-center gap-2 mb-1">
                                                                        <span>{getLanguageFlag(lang)}</span>
                                                                        <span className="text-xs font-medium text-gray-600">
                                                                            {lang === 'en' ? 'English' : 'Hindi'}
                                                                        </span>
                                                                    </div>
                                                                    <p className="text-sm text-gray-700 line-clamp-2">{text}</p>
                                                                </div>
                                                            ))}
                                                        </div>
                                                        <div className="flex items-center gap-4 mt-3 text-xs text-gray-500">
                                                            {page.image_path && (
                                                                <span className="flex items-center gap-1">
                                                                    🖼️ Image
                                                                </span>
                                                            )}
                                                            {page.audio_paths && Object.keys(page.audio_paths).length > 0 && (
                                                                <span className="flex items-center gap-1">
                                                                    🎵 Audio ({Object.keys(page.audio_paths).join(', ')})
                                                                </span>
                                                            )}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                ) : (
                                    <div className="text-center py-8">
                                        <Book className="h-12 w-12 mx-auto text-gray-400 mb-4" />
                                        <h3 className="text-lg font-semibold text-gray-600 mb-2">No pages yet</h3>
                                        <p className="text-gray-500 mb-4">
                                            Start adding pages to bring your story to life!
                                        </p>
                                        <Button
                                            onClick={() => router.visit(`/storybooks/${storybook.id}/pages/create`)}
                                            className="flex items-center gap-2"
                                        >
                                            <Plus className="h-4 w-4" />
                                            Add First Page
                                        </Button>
                                    </div>
                                )}
                            </CardContent>
                        </Card>
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Languages */}
                        <Card>
                            <CardHeader>
                                <CardTitle className="flex items-center gap-2">
                                    <Globe className="h-4 w-4" />
                                    Languages
                                </CardTitle>
                            </CardHeader>
                            <CardContent>
                                <div className="flex gap-2">
                                    {storybook.languages.map((lang) => (
                                        <Badge key={lang} variant="outline" className="flex items-center gap-1">
                                            {getLanguageFlag(lang)}
                                            {lang === 'en' ? 'English' : 'Hindi'}
                                        </Badge>
                                    ))}
                                </div>
                            </CardContent>
                        </Card>

                        {/* Age Group */}
                        {storybook.age_group && (
                            <Card>
                                <CardHeader>
                                    <CardTitle>🎂 Age Group</CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <p className="font-semibold">{storybook.age_group} years</p>
                                </CardContent>
                            </Card>
                        )}

                        {/* Tags */}
                        {storybook.tags && storybook.tags.length > 0 && (
                            <Card>
                                <CardHeader>
                                    <CardTitle className="flex items-center gap-2">
                                        <Tag className="h-4 w-4" />
                                        Tags
                                    </CardTitle>
                                </CardHeader>
                                <CardContent>
                                    <div className="flex flex-wrap gap-2">
                                        {storybook.tags.map((tag, index) => (
                                            <Badge key={index} variant="outline">
                                                {tag}
                                            </Badge>
                                        ))}
                                    </div>
                                </CardContent>
                            </Card>
                        )}

                        {/* Quick Actions */}
                        <Card>
                            <CardHeader>
                                <CardTitle>⚡ Quick Actions</CardTitle>
                            </CardHeader>
                            <CardContent className="space-y-2">
                                <Button
                                    variant="outline"
                                    className="w-full justify-start"
                                    onClick={() => router.visit(`/storybooks/${storybook.id}/pages`)}
                                >
                                    📄 Manage Pages
                                </Button>
                                <Button
                                    variant="outline"
                                    className="w-full justify-start"
                                    onClick={() => router.visit(`/storybooks/${storybook.id}/edit`)}
                                >
                                    ✏️ Edit Details
                                </Button>
                                <Button
                                    variant="outline"
                                    className="w-full justify-start text-red-600 hover:text-red-700"
                                    onClick={() => {
                                        if (confirm('Are you sure you want to delete this storybook?')) {
                                            router.delete(`/storybooks/${storybook.id}`);
                                        }
                                    }}
                                >
                                    🗑️ Delete Storybook
                                </Button>
                            </CardContent>
                        </Card>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}