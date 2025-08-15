import React from 'react';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { router } from '@inertiajs/react';
import { 
    Book, 
    BookOpen, 
    Headphones, 
    Image, 
    Globe, 
    Sparkles, 
    Users,
    Smartphone,
    Settings
} from 'lucide-react';

export default function Welcome() {
    return (
        <div className="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
            {/* Hero Section */}
            <div className="container mx-auto px-4 py-16">
                <div className="text-center space-y-6 mb-16">
                    <div className="flex justify-center mb-6">
                        <div className="bg-gradient-to-r from-blue-600 to-purple-600 p-4 rounded-full">
                            <Book className="h-12 w-12 text-white" />
                        </div>
                    </div>
                    
                    <h1 className="text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        📚 StoryTale CMS
                    </h1>
                    
                    <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                        Create magical children's storybooks with multilingual support, beautiful visuals, 
                        and engaging audio narration. Built for the next generation of digital storytelling.
                    </p>
                    
                    <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <Button 
                            size="lg"
                            onClick={() => router.visit('/storybooks')}
                            className="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 text-lg"
                        >
                            📖 Browse Stories
                        </Button>
                        
                        <Button 
                            variant="outline" 
                            size="lg"
                            onClick={() => router.visit('/login')}
                            className="px-8 py-3 text-lg border-2"
                        >
                            🚀 Create Stories
                        </Button>
                    </div>
                </div>

                {/* Features Grid */}
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                    <Card className="hover:shadow-lg transition-shadow border-0 shadow-md">
                        <CardHeader>
                            <div className="flex items-center gap-3">
                                <div className="bg-blue-100 p-2 rounded-lg">
                                    <BookOpen className="h-6 w-6 text-blue-600" />
                                </div>
                                <CardTitle>Interactive Stories</CardTitle>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <CardDescription>
                                Create engaging storybooks with rich text, beautiful illustrations, 
                                and page-by-page navigation perfect for young readers.
                            </CardDescription>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-lg transition-shadow border-0 shadow-md">
                        <CardHeader>
                            <div className="flex items-center gap-3">
                                <div className="bg-green-100 p-2 rounded-lg">
                                    <Globe className="h-6 w-6 text-green-600" />
                                </div>
                                <CardTitle>Multilingual Support</CardTitle>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <CardDescription>
                                Support for English and Hindi with seamless language switching. 
                                Each story can have content in multiple languages.
                            </CardDescription>
                            <div className="flex gap-2 mt-2">
                                <Badge variant="outline">🇺🇸 English</Badge>
                                <Badge variant="outline">🇮🇳 Hindi</Badge>
                            </div>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-lg transition-shadow border-0 shadow-md">
                        <CardHeader>
                            <div className="flex items-center gap-3">
                                <div className="bg-purple-100 p-2 rounded-lg">
                                    <Headphones className="h-6 w-6 text-purple-600" />
                                </div>
                                <CardTitle>Audio Narration</CardTitle>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <CardDescription>
                                Upload custom audio narration for each page in multiple languages. 
                                Future voice cloning capabilities planned.
                            </CardDescription>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-lg transition-shadow border-0 shadow-md">
                        <CardHeader>
                            <div className="flex items-center gap-3">
                                <div className="bg-orange-100 p-2 rounded-lg">
                                    <Image className="h-6 w-6 text-orange-600" />
                                </div>
                                <CardTitle>Visual Stories</CardTitle>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <CardDescription>
                                Upload and manage high-quality images for each page. 
                                Support for various formats with automatic optimization.
                            </CardDescription>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-lg transition-shadow border-0 shadow-md">
                        <CardHeader>
                            <div className="flex items-center gap-3">
                                <div className="bg-pink-100 p-2 rounded-lg">
                                    <Smartphone className="h-6 w-6 text-pink-600" />
                                </div>
                                <CardTitle>Mobile API</CardTitle>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <CardDescription>
                                RESTful API endpoints for mobile applications. 
                                Easy integration for iOS and Android apps.
                            </CardDescription>
                        </CardContent>
                    </Card>

                    <Card className="hover:shadow-lg transition-shadow border-0 shadow-md">
                        <CardHeader>
                            <div className="flex items-center gap-3">
                                <div className="bg-indigo-100 p-2 rounded-lg">
                                    <Settings className="h-6 w-6 text-indigo-600" />
                                </div>
                                <CardTitle>CMS Dashboard</CardTitle>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <CardDescription>
                                Intuitive content management system for administrators. 
                                Easy story creation, editing, and publishing workflow.
                            </CardDescription>
                        </CardContent>
                    </Card>
                </div>

                {/* Use Cases */}
                <div className="bg-white rounded-2xl p-8 shadow-lg mb-16">
                    <h2 className="text-3xl font-bold text-center mb-8">
                        🎯 Perfect For
                    </h2>
                    
                    <div className="grid md:grid-cols-3 gap-8">
                        <div className="text-center space-y-4">
                            <div className="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto">
                                <Users className="h-8 w-8 text-blue-600" />
                            </div>
                            <h3 className="text-xl font-semibold">Parents & Families</h3>
                            <p className="text-gray-600">
                                Create personalized stories for your children with their favorite characters and themes.
                            </p>
                        </div>
                        
                        <div className="text-center space-y-4">
                            <div className="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto">
                                <Book className="h-8 w-8 text-green-600" />
                            </div>
                            <h3 className="text-xl font-semibold">Publishers</h3>
                            <p className="text-gray-600">
                                Professional publishing platform for children's book publishers and content creators.
                            </p>
                        </div>
                        
                        <div className="text-center space-y-4">
                            <div className="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto">
                                <Sparkles className="h-8 w-8 text-purple-600" />
                            </div>
                            <h3 className="text-xl font-semibold">Educators</h3>
                            <p className="text-gray-600">
                                Create educational content and interactive learning experiences for young students.
                            </p>
                        </div>
                    </div>
                </div>

                {/* API Preview */}
                <div className="bg-gray-900 rounded-2xl p-8 text-white mb-16">
                    <h2 className="text-3xl font-bold text-center mb-8">
                        🚀 Mobile API Ready
                    </h2>
                    
                    <div className="max-w-2xl mx-auto">
                        <div className="bg-gray-800 rounded-lg p-4 font-mono text-sm">
                            <div className="text-green-400">GET</div>
                            <div className="text-blue-300">/api/storybooks</div>
                            <div className="text-gray-400 mt-2">// Get all published storybooks</div>
                            
                            <div className="text-green-400 mt-4">GET</div>
                            <div className="text-blue-300">/api/storybooks/{'{id}'}?language=en</div>
                            <div className="text-gray-400 mt-2">// Get story content in specific language</div>
                        </div>
                        
                        <p className="text-center mt-6 text-gray-300">
                            RESTful API endpoints for seamless mobile app integration
                        </p>
                    </div>
                </div>

                {/* Call to Action */}
                <div className="text-center space-y-6">
                    <h2 className="text-3xl font-bold">
                        Ready to Create Amazing Stories? ✨
                    </h2>
                    
                    <p className="text-xl text-gray-600 max-w-2xl mx-auto">
                        Join thousands of storytellers creating magical experiences for children worldwide.
                    </p>
                    
                    <div className="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        <Button 
                            size="lg"
                            onClick={() => router.visit('/register')}
                            className="bg-gradient-to-r from-green-600 to-blue-600 hover:from-green-700 hover:to-blue-700 text-white px-8 py-3 text-lg"
                        >
                            🎨 Start Creating
                        </Button>
                        
                        <Button 
                            variant="outline" 
                            size="lg"
                            onClick={() => router.visit('/storybooks')}
                            className="px-8 py-3 text-lg border-2"
                        >
                            📚 View Library
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    );
}