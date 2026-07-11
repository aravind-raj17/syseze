import syszeLogo from '../assets/syseze-logo.png';

export default function Logo({ className = 'h-9' }) {
  return <img src={syszeLogo} alt="Syseze" className={`w-auto rounded-md ${className}`} />;
}
