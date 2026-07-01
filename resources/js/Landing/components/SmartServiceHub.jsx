import React, { useRef } from 'react';
import { Canvas, useFrame } from '@react-three/fiber';
import { Float, MeshTransmissionMaterial, ContactShadows, Environment, Stars, Line } from '@react-three/drei';
import * as THREE from 'three';

// A generic "Tech Object" representation (e.g., phone, laptop)
const TechObject = ({ position, rotation, type, color }) => {
    const meshRef = useRef();
    
    useFrame((state) => {
        const t = state.clock.getElapsedTime();
        meshRef.current.rotation.y = rotation[1] + Math.sin(t / 2) * 0.05;
        meshRef.current.rotation.x = rotation[0] + Math.cos(t / 3) * 0.05;
    });

    return (
        <Float speed={2} rotationIntensity={0.2} floatIntensity={1.5}>
            <mesh ref={meshRef} position={position} rotation={rotation} castShadow receiveShadow>
                {type === 'phone' ? (
                    <boxGeometry args={[1, 2, 0.1]} />
                ) : type === 'laptop' ? (
                    <boxGeometry args={[3, 2, 0.1]} />
                ) : type === 'router' ? (
                    <cylinderGeometry args={[1, 1, 0.3, 32]} />
                ) : (
                    <octahedronGeometry args={[1]} />
                )}
                <MeshTransmissionMaterial 
                    backside
                    thickness={0.5}
                    roughness={0.15}
                    transmission={1}
                    ior={1.5}
                    chromaticAberration={0.06}
                    color={color}
                    emissive={color}
                    emissiveIntensity={0.15}
                />
            </mesh>
        </Float>
    );
};

const GlowingLines = () => {
    // Connect the objects
    const points = [
        [-4, 1.5, -2],
        [3.5, 2.5, -4],
        [0, -2.5, -1],
        [-2, -1.5, -3],
        [-4, 1.5, -2]
    ];
    return (
        <Line 
            points={points} 
            color="#F53003" 
            lineWidth={1.5} 
            dashed={false}
            transparent
            opacity={0.4}
        />
    );
};

const Scene = () => {
    const groupRef = useRef();

    useFrame((state) => {
        // Mouse parallax
        const x = (state.pointer.x * Math.PI) / 20;
        const y = (state.pointer.y * Math.PI) / 20;
        
        groupRef.current.rotation.y = THREE.MathUtils.lerp(groupRef.current.rotation.y, x, 0.05);
        groupRef.current.rotation.x = THREE.MathUtils.lerp(groupRef.current.rotation.x, -y, 0.05);
    });

    return (
        <group ref={groupRef}>
            <TechObject type="phone" position={[-4, 1.5, -2]} rotation={[0.2, 0.5, 0]} color="#F53003" />
            <TechObject type="laptop" position={[3.5, 2.5, -4]} rotation={[-0.1, -0.4, 0]} color="#f59e0b" />
            <TechObject type="router" position={[0, -2.5, -1]} rotation={[0.5, 0.1, 0]} color="#3b82f6" />
            <TechObject type="server" position={[-2, -1.5, -3]} rotation={[0.3, 0.8, 0.2]} color="#10b981" />
            
            <GlowingLines />

            <Environment preset="city" />
            <ambientLight intensity={0.4} />
            <directionalLight position={[10, 10, 5]} intensity={1.5} color="#fff" />
            <pointLight position={[-10, -10, -10]} intensity={0.5} color="#F53003" />
            <ContactShadows position={[0, -4, 0]} opacity={0.6} scale={25} blur={2.5} far={4} color="#000" />
        </group>
    );
};

const SmartServiceHub = () => {
    return (
        <div className="absolute inset-0 z-0 pointer-events-auto">
            <Canvas camera={{ position: [0, 0, 10], fov: 40 }} dpr={[1, 2]}>
                <Stars radius={100} depth={50} count={1000} factor={3} saturation={0.5} fade speed={1} />
                <Scene />
            </Canvas>
        </div>
    );
};

export default SmartServiceHub;
