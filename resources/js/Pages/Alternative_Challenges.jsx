import ChallengeModal from '@/Components/ChallengeModal';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export default function Alternative_Challenges({ auth }) {
    const [alternativeChallenges, setAlternativeChallenges] = useState([]);
    const [modalIsOpen, setModalIsOpen] = useState(false);
    const [title, setTitle] = useState('');
    const [value, setValue] = useState('');
    const [editingChallengeId, setEditingChallengeId] = useState(null);


    const handleAlternativeChallenge = async (e) => {
        e.preventDefault();
        try {
          if (editingChallengeId) {
            const response = await fetch(`/alternative_challenges/${editingChallengeId}`, {
              method: 'PUT',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({ title, value }),
            });
      
            if (response.ok) 
            {
              // Update the edited challenge in the challenges array
              const updatedAlternativeChallenge = await response.json();
              const updatedAlternativeChallenges = alternativeChallenges.map((alternativeChallenge) =>
              alternativeChallenge.id === editingChallengeId ? updatedAlternativeChallenge : alternativeChallenge
              );
              setAlternativeChallenges(updatedAlternativeChallenges);
      
              setEditingChallengeId(null); // Clear the editingChallengeId
            } 
            else 
            {
              console.log('Failed to update the challenge.');
            }
          }
          else 
          {
            const response = await fetch('/alternative_challenges', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({ title, value }),
            });
            console.log(response);
            if (response.ok) 
            {
              const newAlternativeChallenge = await response.json();
              setAlternativeChallenges([...alternativeChallenges, newAlternativeChallenge]);
            } 
            else 
            {
              console.log('Failed to add the challenge.');
            }
          }
      
          setModalIsOpen(false); 
          setTitle(''); 
          setValue('');
        } catch (e) {
          console.error('Error occurred while adding/updating the challenge: ', e);
        }
      };
    
    useEffect(() => {
        const getAlternativeChallenges = async () => {
            try {
                const response = await fetch('/api/alternative_challenges', {
                    method: 'GET',
                    headers: {
                        'Content-Type' : 'application/json'
                    }
                });

                if (response.ok) 
                {
                  const data =  await response.json();
                  setAlternativeChallenges(data); // Store fetched challenges data in state
                } 
                else 
                {
                  console.log('Failed to fetch challenges data.');
                }

            } catch (e){
                console.error("Error occured with challenges data: ", e);
            }
        }

        getAlternativeChallenges();
    }, []);

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Alterantive challenges</h2>}
        >
            <Head title="Alterantive challenges" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                        <div className="flex justify-between mb-6">
                            <h3 className="text-lg font-medium">Alterantive challenges</h3>
                            <button 
                            className="px-4 py-2 bg-blue-500 text-white rounded"
                            onClick={() => setModalIsOpen(true)}
                            >
                                Add New Alternative Challenge
                            </button>
                        </div>

                            <table className="min-w-full border-collapse">
                                <thead>
                                    <tr>
                                    <th className="px-4 py-2 border">ID</th>
                                    <th className="px-4 py-2 border">Challenge Title</th>
                                    <th className="px-4 py-2 border">Challenge Value</th>
                                    <th className="px-4 py-2 border">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {alternativeChallenges.map((alternativeChallenge) => (
                                    <tr key={alternativeChallenge.id}>
                                        <td className="px-4 py-2 border">{alternativeChallenge.id}</td>
                                        <td className="px-4 py-2 border">{alternativeChallenge.title}</td>
                                        <td className="px-4 py-2 border">{alternativeChallenge.value}</td>
                                        <td className="px-4 py-2 border">
                                        <button
                                            className="flex items-center px-2 py-1 bg-gray-300 rounded"
                                            onClick={() => {
                                            setTitle(alternativeChallenge.title);
                                            setValue(alternativeChallenge.value);
                                            setEditingChallengeId(alternativeChallenge.id);
                                            setModalIsOpen(true);
                                            }}
                                        >
                                            <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            className="h-4 w-4 mr-1"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            >
                                            <path
                                                fillRule="evenodd"
                                                d="M13.586 2.636a2 2 0 012.828 0l1.949 1.95a2 2 0 010 2.828l-10.92 10.92a3 3 0 01-1.47.78l-3.126.78a.5.5 0 01-.626-.626l.78-3.126a3 3 0 01.78-1.47l10.92-10.92zM15.45 6.808L9.707 12.55l-.707.707H7.21L3.747 13.5l.753-3.042v-.055l5.808-5.807 3.23 3.23z"
                                                clipRule="evenodd"
                                            />
                                            </svg>
                                            Edit
                                        </button>
                                        </td>
                                    </tr>
                                    ))}
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

            <ChallengeModal
                isOpen={modalIsOpen}
                onClose={() => {
                    setModalIsOpen(false);
                    setEditingChallengeId(null);
                }}
                onSubmit={(e) => handleAlternativeChallenge(e)}
                title={title}
                setTitle={setTitle}
                value={value}
                setValue={setValue}
                editingChallengeId={editingChallengeId}
            />
        </AuthenticatedLayout>
    );
}
