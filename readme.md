
# Proyecto LAMP Orquestado (Minikube)

## Requisitos

- Docker
- Minikube
- kubectl

## Pasos de despliegue en una maquina nueva

```bash
# 1) Construir imagenes (tags actuales)
docker build -t mi-proyecto-api:v2 ./api
docker build -t mi-proyecto-web:v2 ./web

# 2) Iniciar minikube
minikube start --memory=3072mb

# 3) Cargar imagenes en minikube
minikube image load mi-proyecto-api:v2
minikube image load mi-proyecto-web:v2

# 4) Aplicar manifiestos
kubectl apply -f k8s/db-deployment.yaml
kubectl rollout status deployment/db-faseb
kubectl apply -f k8s/api-deployment.yaml
kubectl apply -f k8s/web-deployment.yaml

# 5) Acceso (requiere mantener el tunnel abierto)
minikube tunnel
kubectl get svc web-service
```

Abre en el navegador la URL `http://<EXTERNAL-IP>` que te muestre `kubectl get svc web-service`.

## Notas

- El script de inicializacion de la base de datos solo se ejecuta la primera vez (cuando el volumen esta vacio).
- Si tu usuario no esta en el grupo `docker`, usa `sudo` en los comandos `docker build`.
