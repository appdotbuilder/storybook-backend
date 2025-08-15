import React from 'react';
import { AppShell } from '@/components/app-shell';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import { useForm } from '@inertiajs/react';
import { router } from '@inertiajs/react';
import { ArrowLeft } from 'lucide-react';

export default function CreateStorybook() {
    const { data, setData, post, processing, errors } = useForm({
        title: '',
        author: '',
        description: '',
        languages: ['en'],
        status: 'draft',
        age_group: '',
        tags: []
    });

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post('/storybooks');
    };

    const handleLanguageChange = (language: string, checked: boolean) => {
        if (checked) {
            setData('languages', [...data.languages, language]);
        } else {
            setData('languages', data.languages.filter(lang => lang !== language));
        }
    };

    return (
        <AppShell>
            <div className="max-w-2xl mx-auto space-y-6">
                <div className="flex items-center gap-4">
                    <Button
                        variant="outline"
                        onClick={() => router.visit('/storybooks')}
                        className="flex items-center gap-2"
                    >
                        <ArrowLeft className="h-4 w-4" />
                        Back to Library
                    </Button>
                    <div>
                        <Heading title="📖 Create New Storybook" />
                        <p className="text-muted-foreground">
                            Start creating a magical story for children
                        </p>
                    </div>
                </div>

                <form onSubmit={handleSubmit} className="space-y-6 bg-white p-6 rounded-lg shadow-sm border">
                    <div className="grid gap-4">
                        <div>
                            <Label htmlFor="title">Story Title *</Label>
                            <Input
                                id="title"
                                value={data.title}
                                onChange={(e) => setData('title', e.target.value)}
                                placeholder="Enter a magical title..."
                                className="mt-1"
                            />
                            {errors.title && (
                                <p className="text-sm text-red-600 mt-1">{errors.title}</p>
                            )}
                        </div>

                        <div>
                            <Label htmlFor="author">Author *</Label>
                            <Input
                                id="author"
                                value={data.author}
                                onChange={(e) => setData('author', e.target.value)}
                                placeholder="Author name"
                                className="mt-1"
                            />
                            {errors.author && (
                                <p className="text-sm text-red-600 mt-1">{errors.author}</p>
                            )}
                        </div>

                        <div>
                            <Label htmlFor="description">Description</Label>
                            <Textarea
                                id="description"
                                value={data.description}
                                onChange={(e) => setData('description', e.target.value)}
                                placeholder="Tell us about this wonderful story..."
                                className="mt-1 min-h-[100px]"
                            />
                            {errors.description && (
                                <p className="text-sm text-red-600 mt-1">{errors.description}</p>
                            )}
                        </div>

                        <div>
                            <Label>Languages *</Label>
                            <div className="mt-2 space-y-2">
                                <label className="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        checked={data.languages.includes('en')}
                                        onChange={(e) => handleLanguageChange('en', e.target.checked)}
                                        className="rounded"
                                    />
                                    <span>🇺🇸 English</span>
                                </label>
                                <label className="flex items-center gap-2">
                                    <input
                                        type="checkbox"
                                        checked={data.languages.includes('hi')}
                                        onChange={(e) => handleLanguageChange('hi', e.target.checked)}
                                        className="rounded"
                                    />
                                    <span>🇮🇳 Hindi</span>
                                </label>
                            </div>
                            {errors.languages && (
                                <p className="text-sm text-red-600 mt-1">{errors.languages}</p>
                            )}
                        </div>

                        <div>
                            <Label htmlFor="age_group">Age Group</Label>
                            <select
                                id="age_group"
                                value={data.age_group}
                                onChange={(e) => setData('age_group', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="">Select age group</option>
                                <option value="2-4">2-4 years</option>
                                <option value="3-5">3-5 years</option>
                                <option value="5-7">5-7 years</option>
                                <option value="7-9">7-9 years</option>
                                <option value="9-12">9-12 years</option>
                            </select>
                        </div>

                        <div>
                            <Label htmlFor="status">Status</Label>
                            <select
                                id="status"
                                value={data.status}
                                onChange={(e) => setData('status', e.target.value)}
                                className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                    </div>

                    <div className="flex gap-4 pt-4 border-t">
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => router.visit('/storybooks')}
                            disabled={processing}
                        >
                            Cancel
                        </Button>
                        <Button
                            type="submit"
                            disabled={processing}
                            className="flex items-center gap-2"
                        >
                            {processing ? 'Creating...' : 'Create Storybook'}
                        </Button>
                    </div>
                </form>

                <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 className="font-semibold text-blue-900 mb-2">📝 Next Steps</h3>
                    <p className="text-blue-800 text-sm">
                        After creating your storybook, you'll be able to add pages with text, images, and audio narration. 
                        Each page can have content in multiple languages.
                    </p>
                </div>
            </div>
        </AppShell>
    );
}