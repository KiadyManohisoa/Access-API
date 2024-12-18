import re
import socket
import dns.resolver

def is_valid_email(email):
    # Vérifie la syntaxe
    pattern = r'^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$'
    if not re.match(pattern, email):
        return False

    # Vérifie le domaine
    domain = email.split('@')[-1]
    try:
        # Résolution DNS pour MX
        mx_records = dns.resolver.resolve(domain, 'MX')
        return len(mx_records) > 0
    except (dns.resolver.NoAnswer, dns.resolver.NXDOMAIN):
        return False

# Exemple
email = "test@example.com"
print(is_valid_email(email))  # Retourne True si l'e-mail est potentiellement valide
