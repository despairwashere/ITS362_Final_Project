import { useState, useEffect } from 'react';
import { Card, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Search } from 'lucide-react';
import axios from 'axios';

export default function AnimeTracker() {
    const [animeList, setAnimeList] = useState([]);
    const [searchQuery, setSearchQuery] = useState('');
    
    useEffect(() => {
        fetchAnimeData();
    }, []);
    
    const fetchAnimeData = async () => {
        try {
            const response = await axios.get('https://api.jikan.moe/v4/seasons/now');
            setAnimeList(response.data.data);
        } catch (error) {
            console.error('Error fetching anime data:', error);
        }
    };
    
    const handleSearch = () => {
        if (searchQuery.trim() === '') return;
        
        const filteredAnime = animeList.filter(anime => 
            anime.title.toLowerCase().includes(searchQuery.toLowerCase())
        );
        
        setAnimeList(filteredAnime);
    };
    
    return (
        <div className="p-4">
            <div className="flex mb-4">
                <input 
                    type="text" 
                    className="border p-2 rounded w-full" 
                    placeholder="Search for an anime..." 
                    value={searchQuery} 
                    onChange={(e) => setSearchQuery(e.target.value)}
                />
                <Button className="ml-2" onClick={handleSearch}>
                    <Search className="w-5 h-5" />
                </Button>
            </div>
            <Table>
                <TableHeader>
                    <TableRow>
                        <TableHead>Title</TableHead>
                        <TableHead>Episodes</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Next Episode</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {animeList.map((anime) => (
                        <TableRow key={anime.mal_id}>
                            <TableCell>{anime.title}</TableCell>
                            <TableCell>{anime.episodes || 'Unknown'}</TableCell>
                            <TableCell>{anime.status}</TableCell>
                            <TableCell>{anime.broadcast ? anime.broadcast.string : 'N/A'}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </div>
    );
}
//Testing if it pushed, it better