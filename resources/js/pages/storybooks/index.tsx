import React from 'react';
import { AppShell } from '@/components/app-shell';
import Heading from '@/components/heading';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { router } from '@inertiajs/react';
import { Book, Plus, User, Clock, Home } from 'lucide-react';

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
}

interface Props {
    storybooks: {
        data: Storybook[];
        links: Record<string, unknown>;
        meta: Record<string, unknown>;
    };
    auth?: {
        user: Record<string, unknown>;
    } | null;
    [key: string]: unknown;
}

export default function StorybookIndex({ storybooks, auth }: Props) {
    const isAuthenticated = !!auth?.user;
    
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

    const HeaderContent = () => (
        <div className="flex items-center justify-between">
            <div>
                <Heading 
                    title={`📚 ${isAuthenticated ? 'Storybook Library' : 'Published Stories'}`}
                    className="flex items-center gap-2"
                />
                <p className="text-muted-foreground">
                    {isAuthenticated 
                        ? 'Manage your collection of children\'s storybooks'
                        : 'Discover magical stories for children in English and Hindi'
                    }
                </p>
            </div>
            <div className="flex gap-2">
                {!isAuthenticated && (
                    <Button 
                        variant="outline"
                        onClick={() => router.visit('/')}
                        className="flex items-center gap-2"
                    >
                        <Home className="h-4 w-4" />
                        Home
                    </Button>
                )}
                {isAuthenticated ? (
                    <Button 
                        onClick={() => router.visit('/storybooks/create')}
                        className="flex items-center gap-2"
                    >
                        <Plus className="h-4 w-4" />
                        Create Storybook
                    </Button>
                ) : (
                    <Button 
                        onClick={() => router.visit('/login')}
                        className="flex items-center gap-2"
                    >
                        <Plus className="h-4 w-4" />
                        Start Creating
                    </Button>
                )}
            </div>
        </div>
    );

    const content = (
        <div className="space-y-6">
            <HeaderContent />

            <div className="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                {storybooks.data
                    .filter(storybook => !isAuthenticated ? storybook.status === 'published' : true)
                    .map((storybook) => (
                    <Card 
                        key={storybook.id} 
                        className="hover:shadow-lg transition-shadow cursor-pointer"
                        onClick={() => router.visit(isAuthenticated ? `/storybooks/${storybook.id}` : '#')}
                    >
                        <CardHeader className="pb-3">
                            <div className="flex items-start justify-between">
                                <div className="flex-1">
                                    <CardTitle className="text-lg line-clamp-2">
                                        {storybook.title}
                                    </CardTitle>
                                    <CardDescription className="flex items-center gap-1 mt-1">
                                        <User className="h-3 w-3" />
                                        {storybook.author}
                                    </CardDescription>
                                </div>
                                {isAuthenticated && (
                                    <Badge className={getStatusColor(storybook.status)}>
                                        {storybook.status}
                                    </Badge>
                                )}
                            </div>
                        </CardHeader>
                        
                        <CardContent className="space-y-3">
                            {storybook.description && (
                                <p className="text-sm text-muted-foreground line-clamp-2">
                                    {storybook.description}
                                </p>
                            )}
                            
                            <div className="flex items-center gap-4 text-sm text-muted-foreground">
                                <span className="flex items-center gap-1">
                                    <Book className="h-3 w-3" />
                                    {storybook.page_count} pages
                                </span>
                                {storybook.age_group && (
                                    <span>Ages {storybook.age_group}</span>
                                )}
                            </div>
                            
                            <div className="flex items-center justify-between">
                                <div className="flex gap-1">
                                    {storybook.languages.map((lang) => (
                                        <span key={lang} title={lang === 'en' ? 'English' : 'Hindi'}>
                                            {getLanguageFlag(lang)}
                                        </span>
                                    ))}
                                </div>
                                
                                <div className="flex items-center gap-1 text-xs text-muted-foreground">
                                    <Clock className="h-3 w-3" />
                                    {new Date(storybook.updated_at).toLocaleDateString()}
                                </div>
                            </div>
                            
                            {storybook.tags && storybook.tags.length > 0 && (
                                <div className="flex flex-wrap gap-1">
                                    {storybook.tags.slice(0, 3).map((tag, index) => (
                                        <Badge key={index} variant="outline" className="text-xs">
                                            {tag}
                                        </Badge>
                                    ))}
                                    {storybook.tags.length > 3 && (
                                        <Badge variant="outline" className="text-xs">
                                            +{storybook.tags.length - 3}
                                        </Badge>
                                    )}
                                </div>
                            )}
                        </CardContent>
                    </Card>
                ))}
            </div>

            {storybooks.data.filter(sb => !isAuthenticated ? sb.status === 'published' : true).length === 0 && (
                <div className="text-center py-12">
                    <Book className="h-12 w-12 mx-auto text-muted-foreground mb-4" />
                    <h3 className="text-lg font-semibold mb-2">
                        {isAuthenticated ? 'No storybooks yet' : 'No published stories available'}
                    </h3>
                    <p className="text-muted-foreground mb-4">
                        {isAuthenticated 
                            ? 'Create your first storybook to get started with your children\'s library.'
                            : 'Check back later for new stories, or sign in to start creating your own!'
                        }
                    </p>
                    <Button 
                        onClick={() => router.visit(isAuthenticated ? '/storybooks/create' : '/login')}
                        className="flex items-center gap-2"
                    >
                        <Plus className="h-4 w-4" />
                        {isAuthenticated ? 'Create Your First Storybook' : 'Sign In to Create Stories'}
                    </Button>
                </div>
            )}
        </div>
    );

    return isAuthenticated ? (
        <AppShell>
            {content}
        </AppShell>
    ) : (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
            <div className="container mx-auto px-4 py-16">
                {content}
            </div>
        </div>
    );
}