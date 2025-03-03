<script setup lang="ts">
import { onMounted, ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Task',
        href: '/all',
    },
];

const tasks = ref([]);

const fetchTasks = async () => {
    // You should fetch tasks from an API or Inertia route
    const response = await fetch('/api/tasks'); // or use Inertia for this
    tasks.value = await response.json();
};

const handleEditTask = (id: number) => {
    // Implement your edit logic here
};

const handleDeleteTask = (id: number) => {
    // Implement your delete logic here
};

onMounted(() => {
    fetchTasks();

    // Listen for 'task.created', 'task.updated', and 'task.deleted' events
    window.Echo.channel('tasks')
        .listen('TaskCreatedEvent', (event) => {
            // Add the newly created task to the list in real time
            tasks.value.push(event.task);
        })
        .listen('TaskUpdatedEvent', (event) => {
            // Update the task in the list when it is updated
            const index = tasks.value.findIndex(task => task.id === event.task.id);
            if (index !== -1) {
                tasks.value[index] = event.task;
            }
        })
        .listen('TaskDeletedEvent', (event) => {
            // Remove the task from the list when it is deleted
            tasks.value = tasks.value.filter(task => task.id !== event.task.id);
        });
});
</script>

<template>
    <Head title="Tasks" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Table>
                <TableCaption> A list of all the Tasks</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>ID</TableHead>
                        <TableHead>Title</TableHead>
                        <TableHead>Description</TableHead>
                        <TableHead>Status</TableHead>
                        <TableHead>Due Date</TableHead>
                        <TableHead>Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="task in tasks" :key="task.id">
                        <TableCell>{{ task.id }}</TableCell>
                        <TableCell>{{ task.title }}</TableCell>
                        <TableCell>{{ task.description }}</TableCell>
                        <TableCell>{{ task.status }}</TableCell>
                        <TableCell>{{ task.dueDate }}</TableCell>
                        <TableCell>
                            <button @click="handleEditTask(task.id)">Edit</button>
                            <button @click="handleDeleteTask(task.id)">Delete</button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
